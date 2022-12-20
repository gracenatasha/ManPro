#!/usr/bin/env python


from cmath import sqrt
from operator import le
from tkinter.messagebox import NO
from xml.etree.ElementTree import tostring
import mysql.connector
from mysql.connector import Error
from datetime import date
import pandas as pd

from sklearn import cluster
from sklearn.cluster import KMeans
import numpy as np
import seaborn as sns

import matplotlib.pyplot as plt
import plotly.graph_objects as go
from kneed import KneeLocator
from sklearn.datasets import make_blobs
from sklearn.cluster import KMeans
from sklearn.metrics import silhouette_score
from sklearn.preprocessing import StandardScaler


try:
    connection = mysql.connector.connect(host='localhost',
                                         database='donor_darah5',
                                         user='root',
                                         password='')
    if connection.is_connected():
        db_Info = connection.get_server_info()

        cursor = connection.cursor(buffered=True)

        # function recency
        def recency(id_pendonor):
            sql_recent = "SELECT tanggal_event FROM donor d JOIN event e ON d.id_event = e.id_event WHERE e.tanggal_event IN (SELECT max(e.tanggal_event) FROM donor d JOIN event e  ON d.id_event = e.id_event WHERE d.id_pendonor=" + \
                id_pendonor+") AND id_pendonor="+id_pendonor
            cursor.execute(sql_recent)
            recent_date = cursor.fetchone()

            if (recent_date is not None):
                today = date.today()
                diff = today - recent_date[0]
                return diff.days
            return None

        # function frequency
        def frequency(id_pendonor):
            sql_frequency = "SELECT COUNT(id_donor) FROM `donor` WHERE id_pendonor = " + \
                id_pendonor+" GROUP BY id_pendonor"
            cursor.execute(sql_frequency)
            freq = cursor.fetchone()

            if (freq is not None):
                return freq[0]
            return 0

        # function monetary
        def monetary(id_pendonor):
            sql_monetary = "SELECT SUM(jumlah_darah) FROM donor WHERE id_pendonor="+id_pendonor
            cursor.execute(sql_monetary)
            mon = cursor.fetchone()

            if (mon is not None and mon[0] is not None):
                return float(mon[0])
            return 0

        # get all id pendonor
        sql_id_pendonor = "SELECT id_pendonor FROM `pendonor`"
        cursor.execute(sql_id_pendonor)
        id_pendonor = cursor.fetchall()  # isinya ID PENDONOR

        all_id = []

        # RECENCY-----------------------------
        recency_array = []
        for pendonor in id_pendonor:
            recency_array.append(recency(str(pendonor[0])))
            all_id.append(pendonor[0])


        # coba fetch data pendonor
        sql_pendonor = "SELECT * FROM `pendonor`"
        cursor.execute(sql_pendonor)
        data_pendonor = cursor.fetchall()
        df_pendonor = pd.DataFrame(data_pendonor)

        # get max recency
        recency_max = 0
        for i in recency_array:
            if (i is not None):
                if (i > recency_max):
                    recency_max = i

        # get min recency
        recency_min = recency_max
        for i in recency_array:
            if (i is not None):
                if (i < recency_min):
                    recency_min = i

        # min-max normalization to 1-5 (recency)
        normalized_recency_arr = []
        if (recency_max == recency_min):
            for i in recency_array:
                normalized_recency_arr.append(0)
        else:
            for i in recency_array:
                if (i is not None):
                    normalized_recency_arr.append(6-((i-recency_min)/(recency_max - recency_min)*4+1))
                else:
                    normalized_recency_arr.append(1.0)


        # FREQUENCY-----------------------------
        frequency_array = []
        for pendonor in id_pendonor:
            frequency_array.append(frequency(str(pendonor[0])))

        # get max frequency
        frequency_max = 0
        for i in frequency_array:
            if (i is not None):
                if (i > frequency_max):
                    frequency_max = i

        # get min frequency
        frequency_min = frequency_max
        for i in frequency_array:
            if (i is not None):
                if (i < frequency_min):
                    frequency_min = i

        # min-max normalization to 1-5 (frequency)
        normalized_frequency_arr = []
        if (frequency_max == frequency_min):
            for i in frequency_array:
                normalized_frequency_arr.append(0)
        else:
            for i in frequency_array:
                if (i is not None):
                    normalized_frequency_arr.append((i-frequency_min)/(frequency_max - frequency_min)*4+1)
                else:
                    normalized_frequency_arr.append(1.0)

        # MONETARY------------------------------------------------------------
        monetary_array = []
        for pendonor in id_pendonor:
            monetary_array.append(monetary(str(pendonor[0])))

        # get max frequency
        monetary_max = 0
        for i in monetary_array:
            if (i is not None):
                if (i > monetary_max):
                    monetary_max = i

        # get min frequency
        monetary_min = monetary_max
        for i in monetary_array:
            if (i is not None):
                if (i < monetary_min):
                    monetary_min = i


        # min-max normalization to 1-5 (frequency)
        normalized_monetary_arr = []
        if (monetary_max == monetary_min):  # kalo datanya sama, jd gabisa dicari minmax normalization nya
            for i in monetary_array:
                normalized_monetary_arr.append(0)
        else:
            for i in monetary_array:
                if (i is not None):
                    normalized_monetary_arr.append((i-monetary_min)/(monetary_max - monetary_min)*4+1)
                else:
                    normalized_monetary_arr.append(1.0)


        # RFM TOTAL-----------------------------------------
        rfm_total_arr = []
        for i in range(len(monetary_array)):
            if (normalized_recency_arr[i] is None):
                rfm_total_arr.append(0)
            else:
                rfm_total_arr.append(
                    normalized_recency_arr[i]+normalized_frequency_arr[i]+normalized_monetary_arr[i])


        #RFM------------------------------------------
        rfm_arr = []
        for i in range(len(monetary_array)): 
            rfm_arr.append(int(normalized_recency_arr[i]*100 + normalized_frequency_arr[i]*10 + normalized_monetary_arr[i]))


        #CLUSTERING-------------------------------------------
        list = []
        for i in range(len(normalized_recency_arr)): 
            list.append([normalized_recency_arr[i], normalized_frequency_arr[i], normalized_monetary_arr[i]])


        data = np.asarray(list)

        features, true_labels = make_blobs(
            n_samples=200,
            centers=3,
            cluster_std=2.75,
            random_state=None
        )

        #elbow
        kmeans_kwargs = {
            "init": "random",
            "n_init": 10,
            "max_iter": 300,
            "random_state": 42,
        }

        sse = []
        for k in range(1, 11):
            kmeans = KMeans(n_clusters=k, **kmeans_kwargs)
            kmeans.fit(data)
            sse.append(kmeans.inertia_)

            

        #plot hasil elbow
        plt.style.use("fivethirtyeight")
        plt.plot(range(1, 11), sse)
        plt.xticks(range(1, 11))
        plt.xlabel("Number of Clusters")
        plt.ylabel("SSE")
        # plt.show()
        plt.title("Elbow Score")
        plt.savefig('elbow.png')
        kl = KneeLocator(
            range(1, 11), sse, curve="convex", direction="decreasing"
        )
        
        
        #silhouette index
        # obs = np.concatenate( (np.random.randn(100, 2) , 20 + np.random.randn(300, 2) , -15+np.random.randn(200, 2)))
        obs = data
        # print("obs: ", obs)
        silhouette_score_values=[]
        
        NumberOfClusters=range(2,11)
        plt.clf()
        for i in NumberOfClusters:
            classifier=cluster.KMeans(i,init='k-means++', n_init=10, max_iter=20, tol=0.0001, verbose=0, random_state=42, copy_x=True)
            classifier.fit(obs)
            labels= classifier.predict(obs)
            silhouette_score_values.append(silhouette_score(obs,labels ,metric='euclidean', sample_size=None, random_state=42))
        plt.plot(NumberOfClusters, silhouette_score_values)
        plt.title("Silhouette Score")
        plt.xlabel("Number of Clusters")
        plt.ylabel("Silhouette Score Values")
        plt.savefig('silhouette.png')

        
        Optimal_NumberOf_Components=NumberOfClusters[silhouette_score_values.index(max(silhouette_score_values))]

        preds = kmeans.fit_predict(data)
        kmeans.fit(data)
        centers = kmeans.cluster_centers_
        score = silhouette_score(data, preds)
        # print("For n_clusters = {}, silhouette score is {})".format(k, score))
        print(score)


        #CLUSTERING K-MEANS-----------------------------------------
        kmeans = KMeans(
            init="random",
            n_clusters=kl.elbow,
            n_init=10,
            max_iter=300,
            random_state=42
        )
        # kmeans.inertia_

        def euclidean(r1, f1, m1, r2, f2, m2):
            temp = (pow(r1-r2, 2)+pow(f1-f2, 2)+pow(m1-m2, 2))**0.5
            return temp

        nocluster = kl.elbow
        centroid = kmeans.cluster_centers_
        cluster = []
        for i in range(len(normalized_frequency_arr)): 
            temp = []
            for j in range(nocluster): 
                temp.append(euclidean(normalized_recency_arr[i], normalized_frequency_arr[i], normalized_monetary_arr[i], centroid[j][0], centroid[j][1], centroid[j][2]))
            minIndex = temp.index(min(temp))
            cluster.append([minIndex, [normalized_recency_arr[i], normalized_frequency_arr[i], normalized_monetary_arr[i]]])

        clustered = [] #hasil clustering, tapi masih belum urut index nya (dari data paling bagus ke paling jelek masih acak)
        for i in range(nocluster): 
            temp = []
            for j in range(len(cluster)): 
                if(cluster[j][0] == i): 
                    temp.append(cluster[j][1])
            clustered.append(temp)


        #mengurutkan hasil clustering dari data paling jelek ke paling bagus
        avg = []
        for i in range(len(clustered)): 
            temp = 0
            j_count = 0
            for j in range(len(clustered[i])): 
                temp += clustered[i][j][0] + clustered[i][j][1] + clustered[i][j][2]
                j_count+=1
            avg.append(temp/j_count)
        sorted_index = np.argsort(avg)
        sorted = []
        for i in range(len(sorted_index)): 
            sorted.append(clustered[sorted_index[i]])

        # hasil: dari paling jelek (index 0) - paling bagus (index n)
        # for i in range(len(sorted)): 
        #     print("i: ", i, " ", sorted[i])


        #plot hasil
        fig = plt.figure(figsize = (10,10))
        ax = plt.axes(projection='3d')
        ax.grid()

        r = []
        f = []
        m = []
        hasil = []

        colors = np.array(["red","green","blue","yellow","pink","black","orange","purple","beige","brown","gray","cyan","magenta"])
        label = np.array(["Lost", "Hibernating", "Can't Lose Them", "At Risk", "About to Sleep", "Needing Attention", "Promising"])

        col = np.random.rand(len(sorted))
        color = []
        for i in range(len(sorted)): 
            temp = []
            for j in range(len(sorted[i])): 
                r.append(sorted[i][j][0])
                f.append(sorted[i][j][1])
                m.append(sorted[i][j][2])
                color.append(colors[i])
            # print(len(r), len(f), len(m))
        
        r = np.asarray(r)
        f = np.asarray(f)
        m = np.asarray(m)
        colors = np.asarray(color)

        col = []
        for i in range(len(r)): 
            col.append(i)
        col = np.asarray(col)


        #MATPLOT-----------------------------------------------------------
        # ax.scatter(r, f, m, c = colors, s = 50, alpha=0.5, label = label[i])
        # ax.set_title('RFM Clustering Result')

        # ax.set_xlabel('R (Recency)', labelpad=20)
        # ax.set_ylabel('F (Frequency)', labelpad=20)
        # ax.set_zlabel('M (Monetary)', labelpad=20)

        # plt.show()
        # plt.savefig('clustering.png')

        #COBA PLOTLY-------------------------------------------
        # Helix equation

        fig = go.Figure(data=[go.Scatter3d(
            x=r,
            y=f,
            z=m,
            mode='markers',
            marker=dict(
                size=8,
                color=col,
                colorscale='Viridis',   # choose a colorscale
                opacity=0.8
            )
        )])

        # tight layout
        fig.update_layout(margin=dict(l=0, r=0, b=0, t=0))
        fig.write_html("clustering.html")
        fig.show()
        
        # NEW -- Add RFM Columns to Initial DataFrame
        df_pendonor.columns = ['ID', 'Nama Pendonor', 'Tanggal Lahir', 'Jenis Kelamin', 'Golongan Darah',
                               'Rhesus', 'Alamat', 'ID Kelurahan Rumah', 'Alamat Kantor', 'ID Kelurahan Kantor', 'No Telepon', 'E-mail']
        df_pendonor['Recency'] = normalized_recency_arr
        df_pendonor['Frequency'] = normalized_frequency_arr
        df_pendonor['Monetary'] = normalized_monetary_arr
        df_pendonor['RFM'] = rfm_total_arr
        df_pendonor.pop('ID Kelurahan Rumah')
        df_pendonor.pop('ID Kelurahan Kantor')
        #print(df_pendonor)

        # Nyambungin ke PHP/HTML
        # new_df = df_pendonor.set_index('ID')
        html_table = df_pendonor.to_html(classes='table table-striped rfm_table', index=False)
        # kalo ga bisa, coba write html to file
        text_file = open("table_data.php", "w")
        text_file.write(html_table)
        text_file.close()

        # new_df = df_pendonor.set_index('ID')
        # print(new_df)
        # print(df_pendonor)

except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        #print("MySQL connection is closed")

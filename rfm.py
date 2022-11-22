#!/usr/bin/env python

from cmath import sqrt
from operator import le
from tkinter.messagebox import NO
from xml.etree.ElementTree import tostring
import mysql.connector
from mysql.connector import Error
from datetime import date
import pandas as pd

from sklearn.cluster import KMeans
import numpy as np

import matplotlib.pyplot as plt
from kneed import KneeLocator
from sklearn.datasets import make_blobs
from sklearn.cluster import KMeans
from sklearn.metrics import silhouette_score
from sklearn.preprocessing import StandardScaler


try:
    connection = mysql.connector.connect(host='localhost',
                                         database='donor_darah4',
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
        # print(id_pendonor)

        all_id = []

        # RECENCY-----------------------------
        recency_array = []
        for pendonor in id_pendonor:
            # print("Pendonor: ", pendonor[0])
            # print("recency: ", recency(str(pendonor[0])))
            recency_array.append(recency(str(pendonor[0])))
            all_id.append(pendonor[0])


        # coba fetch data pendonor
        sql_pendonor = "SELECT * FROM `pendonor`"
        cursor.execute(sql_pendonor)
        data_pendonor = cursor.fetchall()
        df_pendonor = pd.DataFrame(data_pendonor)
        # print(df_pendonor)

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

        # print("max: ", recency_max, " min: ", recency_min)

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

        print("recency array: ", normalized_recency_arr)

        # FREQUENCY-----------------------------
        frequency_array = []
        for pendonor in id_pendonor:
            # print("Pendonor: ", pendonor[0])
            # print("freq: ", frequency(str(pendonor[0])))
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

        print("freq arr: ", normalized_frequency_arr)

        # MONETARY------------------------------------------------------------
        monetary_array = []
        for pendonor in id_pendonor:
            # print("Pendonor: ", pendonor[0])
            # print("mon: ", monetary(str(pendonor[0])))
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

        print("MINMAXMON: ", monetary_max, monetary_min)

        # min-max normalization to 1-5 (frequency)
        normalized_monetary_arr = []
        if (monetary_max == monetary_min):  # kalo datanya sama, jd gabisa dicari minmax normalization nya
            for i in monetary_array:
                normalized_monetary_arr.append(0)
        else:
            for i in monetary_array:
                if (i is not None):
                    # print(i)
                    normalized_monetary_arr.append((i-monetary_min)/(monetary_max - monetary_min)*4+1)
                else:
                    normalized_monetary_arr.append(1.0)

        print("mon: ", normalized_monetary_arr)

        # RFM TOTAL-----------------------------------------
        rfm_total_arr = []
        for i in range(len(monetary_array)):
            if (normalized_recency_arr[i] is None):
                rfm_total_arr.append(0)
            else:
                print("TYPE: ", type(normalized_recency_arr[i]), type(normalized_frequency_arr[i]), type(normalized_monetary_arr), normalized_monetary_arr)
                rfm_total_arr.append(
                    normalized_recency_arr[i]+normalized_frequency_arr[i]+normalized_monetary_arr[i])

        print("rfm total: ", rfm_total_arr)


        #RFM------------------------------------------
        rfm_arr = []
        for i in range(len(monetary_array)): 
            rfm_arr.append(int(normalized_recency_arr[i]*100 + normalized_frequency_arr[i]*10 + normalized_monetary_arr[i]))

        print("rfm: ", rfm_arr)


        #CLUSTERING-------------------------------------------
        list = []
        for i in range(len(normalized_recency_arr)): 
            list.append([normalized_recency_arr[i], normalized_frequency_arr[i], normalized_monetary_arr[i]])


        data = np.asarray(list)
        print(data)

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

        kl = KneeLocator(
            range(1, 11), sse, curve="convex", direction="decreasing"
        )

        # print("elbow: ", kl.elbow)


        #CLUSTERING K-MEANS-----------------------------------------
        kmeans = KMeans(
            init="random",
            n_clusters=kl.elbow,
            n_init=10,
            max_iter=300,
            random_state=42
        )
        print(kmeans.fit(data))
        kmeans.inertia_
        print("cluster centers: ", kmeans.cluster_centers_) #center nya
        print("iteration: ", kmeans.n_iter_)

        def euclidean(r1, f1, m1, r2, f2, m2):
            temp = (pow(r1-r2, 2)+pow(f1-f2, 2)+pow(m1-m2, 2))**0.5
            return temp

        nocluster = kl.elbow
        centroid = kmeans.cluster_centers_
        cluster = []
        print("len normalized: ", len(normalized_frequency_arr))
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

        print(len(cluster), len(clustered))
        print("cluster", cluster)
        print("ed", clustered)
        print("CLUSTERING: -----------------------------------------------")
        for i in range(len(clustered)): 
            print("i: ", i, len(clustered[i]), " ", clustered[i])


        #mengurutkan hasil clustering dari data paling jelek ke paling bagus
        avg = []
        for i in range(len(clustered)): 
            temp = 0
            j_count = 0
            for j in range(len(clustered[i])): 
                temp += clustered[i][j][0] + clustered[i][j][1] + clustered[i][j][2]
                j_count+=1
            avg.append(temp/j_count)
        print("AVG: ", avg)
        sorted_index = np.argsort(avg)
        print("sorted: ", sorted_index)
        sorted = []
        for i in range(len(sorted_index)): 
            sorted.append(clustered[sorted_index[i]])

        # hasil: dari paling jelek (index 0) - paling bagus (index n)
        for i in range(len(sorted)): 
            print("i: ", i, " ", sorted[i])


        #plot hasil
        print("JUMLAH HASIL: ", len(sorted), "--------------------")
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
            # r = np.asarray(r)
            # f = np.asarray(f)
            # m = np.asarray(m)
            print(len(r), len(f), len(m))
            # ax.scatter(r, f, m, c = colors[i], s = 50, cmap = 'viridis')
            # r = []
            # f = []
            # m = []
        
        r = np.asarray(r)
        f = np.asarray(f)
        m = np.asarray(m)
        colors = np.asarray(color)


        ax.scatter(r, f, m, c = colors, s = 50, alpha=0.5, label = label[i])
        ax.set_title('RFM Clustering Result')

        ax.set_xlabel('R (Recency)', labelpad=20)
        ax.set_ylabel('F (Frequency)', labelpad=20)
        ax.set_zlabel('M (Monetary)', labelpad=20)


        plt.show()


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
        html_table = df_pendonor.to_html(classes='table table-striped')
        # print(html_table) #ini yg hrsnya di outputin ke sblh
        # kalo ga bisa, coba write html to file
        #text_file = open("table.html", "w")
        #text_file.write(html_table)
        #text_file.close()

except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        #print("MySQL connection is closed")

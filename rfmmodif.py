#!/usr/bin/env python

from tkinter.messagebox import NO
from xml.etree.ElementTree import tostring
import mysql.connector
from mysql.connector import Error
from datetime import date
import pandas as pd
import sys
from sklearn.preprocessing import StandardScaler as SS # z-score standardization 
from sklearn.cluster import KMeans, DBSCAN # clustering algorithms
from sklearn.decomposition import PCA # dimensionality reduction
from sklearn.metrics import silhouette_score # used as a metric to evaluate the cohesion in a cluster
from sklearn.neighbors import NearestNeighbors # for selecting the optimal eps value when using DBSCAN
import numpy as np
# plotting libraries
import matplotlib.pyplot as plt
import seaborn as sns
from yellowbrick.cluster import SilhouetteVisualizer


try:
    connection = mysql.connector.connect(host='localhost',
                                         database='database',
                                         user='root',
                                         password='')
    if connection.is_connected():
        db_Info = connection.get_server_info()

        cursor = connection.cursor(buffered=True)

        # function recency
        def recency(id_pendonor):
            sql_recent = "SELECT tanggal_event FROM donor d JOIN event e ON d.id_event = e.id_event WHERE e.tanggal_event IN (SELECT max(e.tanggal_event) FROM donor d JOIN event e  ON d.id_event = e.id_event WHERE d.id_pendonor=" + \
                str(id_pendonor)+") AND id_pendonor="+str(id_pendonor)
            cursor.execute(sql_recent)
            recent_date = cursor.fetchone()

            if (recent_date is not None):
                today = date.today()
                diff = today - recent_date[0]
                return diff.days
            return 0

        # function frequency
        def frequency(id_pendonor, period):
            if str(period) == 'All':
                sql_frequency = "SELECT COUNT(id_donor) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = "+str(id_pendonor)+" GROUP BY id_pendonor"
            else:
                sql_frequency = "SELECT COUNT(id_donor) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = "+str(id_pendonor)+" AND FLOOR(DATEDIFF(SYSDATE(), e.tanggal_event)/365) <= "+str(period)+" GROUP BY id_pendonor"
            cursor.execute(sql_frequency)
            freq = cursor.fetchone()

            if (freq is not None):
                return freq[0]
            return 0

        # function monetary
        def monetary(id_pendonor, period):
            if str(period) == 'All':
                sql_monetary = "SELECT SUM(jumlah_darah) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = "+str(id_pendonor)+" GROUP BY d.id_pendonor"
            else:
                sql_monetary = "SELECT SUM(jumlah_darah) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = "+str(id_pendonor)+" AND FLOOR(DATEDIFF(SYSDATE(), e.tanggal_event)/365) <= "+str(period)+" GROUP BY d.id_pendonor"
            cursor.execute(sql_monetary)
            mon = cursor.fetchone()

            if (mon is not None):
                return mon[0]
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
            #print("Pendonor: ", pendonor[0])
            #print("recency: ", recency(str(pendonor[0])))
            recency_array.append(recency(str(pendonor[0])))
            all_id.append(pendonor[0])

        # print(all_id)

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
                    normalized_recency_arr.append(round(6-((i-recency_min)/(recency_max - recency_min)*4+1)))
                else:
                    normalized_recency_arr.append(1)

        #print("recency array: ", normalized_recency_arr)

        # FREQUENCY-----------------------------
        frequency_array = []
        for pendonor in id_pendonor:
            # print("Pendonor: ", pendonor[0])
            # print("freq: ", frequency(str(pendonor[0])))
            freqmodif = [frequency(str(pendonor[0]), 1), frequency(str(pendonor[0]), 2), frequency(str(pendonor[0]), 3), frequency(str(pendonor[0]), 'All')]
            frequency_array.append(freqmodif)

        # get max frequency
        frequency1_max = frequency2_max = frequency3_max = frequencyall_max = 0

        for i in frequency_array: #i = array isi 4 index [1 year, 2 year, 3 year, all]
            if (i[0] > frequency1_max):
                frequency1_max = i[0]
            if (i[1] > frequency2_max):
                frequency2_max = i[1]
            if (i[2] > frequency3_max):
                frequency3_max = i[2]
            if (i[3] > frequencyall_max):
                frequencyall_max = i[3]

        # get min frequency
        frequency1_min = frequency2_min = frequency3_min = frequencyall_min = frequencyall_max
        for i in frequency_array:
            if (i[0] < frequency1_min):
                frequency1_min = i[0]
            if (i[1] < frequency2_min):
                frequency2_min = i[1]
            if (i[2] < frequency3_min):
                frequency3_min = i[2]
            if (i[3] < frequencyall_min):
                frequencyall_min = i[3]


        # min-max normalization to 1-5 (frequency)
        normalized_frequency_arr = []
        for i in frequency_array:
            freqset = []
            if (i[0] > 0 and frequency1_max != frequency1_min):
                freqset.append(round((i[0]-frequency1_min)/(frequency1_max - frequency1_min)*4+1))
            else:
                freqset.append(1)
            if (i[1] > 0 and frequency2_max != frequency2_min):
                freqset.append(round((i[1]-frequency2_min)/(frequency2_max - frequency2_min)*4+1))
            else:
                freqset.append(1)
            if (i[2] > 0 and frequency3_max != frequency3_min):
                freqset.append(round((i[2]-frequency3_min)/(frequency3_max - frequency3_min)*4+1))
            else:
                freqset.append(1)
            if (i[3] > 0 and frequencyall_max != frequencyall_min):
                freqset.append(round((i[3]-frequencyall_min)/(frequencyall_max - frequencyall_min)*4+1))
            else:
                freqset.append(1)
            normalized_frequency_arr.append(freqset)

        #print("freq arr: ", normalized_frequency_arr)

        # MONETARY------------------------------------------------------------
        monetary_array = []
        for pendonor in id_pendonor:
            # print("Pendonor: ", pendonor[0])
            #print("mon: ", monetary(str(pendonor[0])))
            monmodif = [int(monetary(str(pendonor[0]), 1)), int(monetary(str(pendonor[0]), 2)), int(monetary(str(pendonor[0]), 3)), int(monetary(str(pendonor[0]), 'All'))]
            monetary_array.append(monmodif)

        # get max monetary
        monetary1_max = monetary2_max = monetary3_max = monetaryall_max = 0

        for i in monetary_array: #i = array isi 4 index [1 year, 2 year, 3 year, all]
            if (i[0] > monetary1_max):
                monetary1_max = i[0]
            if (i[1] > monetary2_max):
                monetary2_max = i[1]
            if (i[2] > monetary3_max):
                monetary3_max = i[2]
            if (i[3] > monetaryall_max):
                monetaryall_max = i[3]

        # get min monetary
        monetary1_min = monetary2_min = monetary3_min = monetaryall_min = monetaryall_max
        for i in monetary_array:
            if (i[0] < monetary1_min):
                monetary1_min = i[0]
            if (i[1] < monetary2_min):
                monetary2_min = i[1]
            if (i[2] < monetary3_min):
                monetary3_min = i[2]
            if (i[3] < monetaryall_min):
                monetaryall_min = i[3]


        # min-max normalization to 1-5 (monetary)
        normalized_monetary_arr = []
        for i in monetary_array:
            monset = []
            if (i[0] > 0 and monetary1_max != monetary1_min):
                monset.append(round((i[0]-monetary1_min)/(monetary1_max - monetary1_min)*4+1))
            else:
                monset.append(1)
            if (i[1] > 0 and monetary2_max != monetary2_min):
                monset.append(round((i[1]-monetary2_min)/(monetary2_max - monetary2_min)*4+1))
            else:
                monset.append(1)
            if (i[2] > 0 and monetary3_max != monetary3_min):
                monset.append(round((i[2]-monetary3_min)/(monetary3_max - monetary3_min)*4+1))
            else:
                monset.append(1)
            if (i[3] > 0 and monetaryall_max != monetaryall_min):
                monset.append(round((i[3]-monetaryall_min)/(monetaryall_max - monetaryall_min)*4+1))
            else:
                monset.append(1)
            normalized_monetary_arr.append(monset)

        #print("mon arr: ", normalized_monetary_arr)

        #print('Recency: ', recency_array)
        #print('Frequency: ', frequency_array)
        #print('Monetary: ', monetary_array)

        # RFM dikalikan weight masing"-----------------------------------------
        # nanti weightnya berubah" berdasarkan input user
        rfm_arr = []
        
        if len(sys.argv) <= 1:
            #print('No arguments')
            r_weight = f_weight = m_weight = 1/3
            f1_weight = f2_weight = f3_weight = fall_weight = 0.25
            m1_weight = m2_weight = m3_weight = mall_weight = 0.25
        elif len(sys.argv) == 4:
            #print('3 arguments')
            r_weight = float(sys.argv[1])
            f_weight = float(sys.argv[2])
            m_weight = float(sys.argv[3])
            f1_weight = f2_weight = f3_weight = fall_weight = 0.25
            m1_weight = m2_weight = m3_weight = mall_weight = 0.25
        else:
            r_weight = float(sys.argv[1])
            f_weight = float(sys.argv[2])
            m_weight = float(sys.argv[3])
            f1_weight = float(sys.argv[4]) #1 year
            f2_weight = float(sys.argv[5]) #2 year
            f3_weight = float(sys.argv[6]) #3 year
            fall_weight = float(sys.argv[7]) #all
            m1_weight = float(sys.argv[8]) #1 year
            m2_weight = float(sys.argv[9]) #2 year
            m3_weight = float(sys.argv[10]) #3 year
            mall_weight = float(sys.argv[11])


        for i in range(len(monetary_array)):
            recency_val = normalized_recency_arr[i]

            frequency_val = f1_weight*normalized_frequency_arr[i][0] + f2_weight*normalized_frequency_arr[i][1] + f3_weight*normalized_frequency_arr[i][2] + fall_weight*normalized_frequency_arr[i][3]
            monetary_val = m1_weight*normalized_monetary_arr[i][0] + m2_weight*normalized_monetary_arr[i][1] + m3_weight*normalized_monetary_arr[i][2] + mall_weight*normalized_monetary_arr[i][3]
            rfm_val = r_weight*recency_val + f_weight*frequency_val + m_weight*monetary_val
            rfm_arr.append(rfm_val)

        #print("rfm: ", rfm_arr)

        # NEW -- Add RFM Columns to Initial DataFrame
        df_pendonor.columns = ['ID', 'Nama Pendonor', 'Tanggal Lahir', 'Jenis Kelamin', 'Golongan Darah',
                               'Rhesus', 'Alamat', 'ID Kelurahan Rumah', 'Alamat Kantor', 'ID Kelurahan Kantor', 'No Telepon', 'E-mail']
        df_pendonor['Recency'] = normalized_recency_arr
        df_pendonor['Frequency'] = normalized_frequency_arr
        df_pendonor['Monetary'] = normalized_monetary_arr
        df_pendonor['RFM'] = rfm_arr
        df_pendonor.pop('ID Kelurahan Rumah')
        df_pendonor.pop('ID Kelurahan Kantor')
        sorted_pendonor = df_pendonor.sort_values(by='RFM', ascending=False)

        def silhouettePlot(range_, data):
            half_length = int(len(range_)/2)
            range_list = list(range_)
            fig, ax = plt.subplots(half_length, 2, figsize=(15,8))
            for _ in range_:
                kmeans = KMeans(n_clusters=_, random_state=42)
                q, mod = divmod(_ - range_list[0], 2)
                sv = SilhouetteVisualizer(kmeans, colors="yellowbrick", ax=ax[q][mod])
                ax[q][mod].set_title("Silhouette Plot with n={} Cluster".format(_))
                sv.fit(data)
            fig.tight_layout()
            fig.show()
            fig.savefig("silhouette_plot.png")

        def elbowPlot(range_, data, figsize=(10,10)):
            inertia_list = []
            for n in range_:
                kmeans = KMeans(n_clusters=n, random_state=42)
                kmeans.fit(data)
                inertia_list.append(kmeans.inertia_)
                
            # plotting
            fig = plt.figure(figsize=figsize)
            ax = fig.add_subplot(111)
            sns.lineplot(y=inertia_list, x=range_, ax=ax)
            ax.set_xlabel("Cluster")
            ax.set_ylabel("Inertia")
            ax.set_xticks(list(range_))
            fig.show()
            fig.savefig("elbow_plot.png")

        def findOptimalEps(n_neighbors, data):
            neigh = NearestNeighbors(n_neighbors=n_neighbors)
            nbrs = neigh.fit(data)
            distances, indices = nbrs.kneighbors(data)
            distances = np.sort(distances, axis=0)
            distances = distances[:,1]
            plt.plot(distances)

        def progressiveFeatureSelection(df, n_clusters=3, max_features=4,):
            feature_list = list(df.columns)
            selected_features = list()
            # select starting feature
            initial_feature = ""
            high_score = 0
            for feature in feature_list:
                kmeans = KMeans(n_clusters=n_clusters, random_state=42)
                data_ = df[feature]
                labels = kmeans.fit_predict(data_.to_frame())
                score_ = silhouette_score(data_.to_frame(), labels)
                print("Proposed new feature {} with score {}". format(feature, score_))
                if score_ >= high_score:
                    initial_feature = feature
                    high_score = score_
            print("The initial feature is {} with a silhouette score of {}.".format(initial_feature, high_score))
            feature_list.remove(initial_feature)
            selected_features.append(initial_feature)
            for _ in range(max_features-1):
                high_score = 0
                selected_feature = ""
                print("Starting selection {}...".format(_))
                for feature in feature_list:
                    selection_ = selected_features.copy()
                    selection_.append(feature)
                    kmeans = KMeans(n_clusters=n_clusters, random_state=42)
                    data_ = df[selection_]
                    labels = kmeans.fit_predict(data_)
                    score_ = silhouette_score(data_, labels)
                    print("Proposed new feature {} with score {}". format(feature, score_))
                    if score_ > high_score:
                        selected_feature = feature
                        high_score = score_
                selected_features.append(selected_feature)
                feature_list.remove(selected_feature)
                print("Selected new feature {} with score {}". format(selected_feature, high_score))
            return selected_features

        scaler = SS()
        print("before")
        print(df_pendonor['RFM'])
        DNP_authors_standardized = scaler.fit_transform(df_pendonor[['RFM']])
        print("after")
        df_authors_standardized = pd.DataFrame(DNP_authors_standardized, columns=["RFM"])
        df_authors_standardized = df_authors_standardized.set_index(df_pendonor.index)
        selected_features = progressiveFeatureSelection(df_authors_standardized, max_features=1, n_clusters=3)
        df_standardized_sliced = df_authors_standardized[selected_features]
        elbowPlot(range(1,11), df_standardized_sliced)
        silhouettePlot(range(3,9), df_standardized_sliced)


        # Nyambungin ke PHP/HTML
        html_table = sorted_pendonor.to_html(classes='table table-striped') 
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

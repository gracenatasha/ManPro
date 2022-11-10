#!/usr/bin/env python

from tkinter.messagebox import NO
from xml.etree.ElementTree import tostring
import mysql.connector
from mysql.connector import Error
from datetime import date
import pandas as pd


try:
    connection = mysql.connector.connect(host='localhost',
                                         database='donor_darah',
                                         user='root',
                                         password='')
    if connection.is_connected():
        db_Info = connection.get_server_info()

        cursor = connection.cursor()

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

        print("recency array: ", normalized_recency_arr)

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

        print("freq arr: ", normalized_frequency_arr)

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

        print("mon arr: ", normalized_monetary_arr)

        print('Recency: ', recency_array)
        print('Frequency: ', frequency_array)
        print('Monetary: ', monetary_array)

        # RFM dikalikan weight masing"-----------------------------------------
        rfm_arr = []
        for i in range(len(monetary_array)):
            recency_val = normalized_recency_arr[i]
            frequency_val = 0.25*normalized_frequency_arr[i][0] + 0.25*normalized_frequency_arr[i][1] + 0.25*normalized_frequency_arr[i][2] + 0.25*normalized_frequency_arr[i][3]
            monetary_val = 0.25*normalized_monetary_arr[i][0] + 0.25*normalized_monetary_arr[i][1] + 0.25*normalized_monetary_arr[i][2] + 0.25*normalized_monetary_arr[i][3]
            rfm_arr.append(1/3*recency_val + 1/3*frequency_val + 1/3*monetary_val)

        print("rfm: ", rfm_arr)

        """ # NEW -- Add RFM Columns to Initial DataFrame
        df_pendonor.columns = ['ID', 'Nama Pendonor', 'Tanggal Lahir', 'Jenis Kelamin', 'Golongan Darah',
                               'Rhesus', 'Alamat', 'ID Kelurahan Rumah', 'Alamat Kantor', 'ID Kelurahan Kantor', 'No Telepon', 'E-mail']
        df_pendonor['Recency'] = normalized_recency_arr
        df_pendonor['Frequency'] = normalized_frequency_arr
        df_pendonor['Monetary'] = normalized_monetary_arr
        df_pendonor['RFM'] = rfm_arr
        df_pendonor.pop('ID Kelurahan Rumah')
        df_pendonor.pop('ID Kelurahan Kantor')
        #print(df_pendonor)

        # Nyambungin ke PHP/HTML
        html_table = df_pendonor.to_html(classes='table table-striped') """
        #print(html_table) #ini yg hrsnya di outputin ke sblh
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

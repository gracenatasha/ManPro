#!/usr/bin/env python

from tkinter.messagebox import NO
from xml.etree.ElementTree import tostring
import mysql.connector #pip install mysql-connector-python
from mysql.connector import Error
from datetime import date
import pandas as pd
import plotly.express as px #pip install plotly.express

try:
    connection = mysql.connector.connect(host='localhost',
                                         database='donor_darah',
                                         user='root',
                                         password='')
    if connection.is_connected():
        db_Info = connection.get_server_info()
        
        cursor = connection.cursor()

        #function recency
        def recency(id_pendonor): 
            sql_recent = "SELECT tanggal_event FROM donor d JOIN event e ON d.id_event = e.id_event WHERE e.tanggal_event IN (SELECT max(e.tanggal_event) FROM donor d JOIN event e  ON d.id_event = e.id_event WHERE d.id_pendonor="+id_pendonor+") AND id_pendonor="+id_pendonor
            cursor.execute(sql_recent)
            recent_date = cursor.fetchone()

            if(recent_date is not None): 
                today = date.today()
                diff = today - recent_date[0]
                return diff.days
            return None

        #function frequency
        def frequency(id_pendonor): 
            sql_frequency = "SELECT COUNT(id_donor) FROM `donor` WHERE id_pendonor = "+id_pendonor+" GROUP BY id_pendonor"; 
            cursor.execute(sql_frequency)
            freq = cursor.fetchone()

            if(freq is not None): 
                return freq[0]
            return 0

        #function monetary
        def monetary(id_pendonor):
            sql_monetary = "SELECT max(jumlah_darah) FROM donor WHERE id_pendonor="+id_pendonor
            cursor.execute(sql_monetary)
            mon = cursor.fetchone()

            if(mon is not None):
                return mon[0]
            return 0

        #get all id pendonor
        sql_id_pendonor = "SELECT id_pendonor FROM `pendonor`"
        cursor.execute(sql_id_pendonor)
        id_pendonor = cursor.fetchall()

        #RECENCY-----------------------------
        recency_array = []
        for pendonor in id_pendonor: 
            # print("Pendonor: ", pendonor[0])
            # print("recency: ", recency(str(pendonor[0])))
            recency_array.append(recency(str(pendonor[0])))

        #FREQUENCY-----------------------------
        frequency_array = []
        for pendonor in id_pendonor: 
            # print("Pendonor: ", pendonor[0])
            # print("freq: ", frequency(str(pendonor[0])))
            frequency_array.append(frequency(str(pendonor[0])))

        #MONETARY------------------------------------------------------------
        monetary_array = []
        for pendonor in id_pendonor: 
            # print("Pendonor: ", pendonor[0])
            # print("mon: ", monetary(str(pendonor[0])))
            monetary_array.append(monetary(str(pendonor[0])))

        #Create Dataframe
        datadict = {'Recency': recency_array, 'Frequency': frequency_array, 'Monetary': monetary_array}
        data = pd.DataFrame(datadict)
        #print(data)
        

        #Buat Graph Recency
        recency6mos = len(data.where(data['Recency'] <= 6).dropna())
        recency6to12mos = len(data.where((data['Recency'] > 6) & (data['Recency'] <= 12)).dropna())
        recency1to2yr = len(data.where((data['Recency'] > 12) & (data['Recency'] <= 24)).dropna())
        recency2to4yr = len(data.where((data['Recency'] > 24) & (data['Recency'] <= 48)).dropna())
        recency4plusyr = len(data.where(data['Recency'] > 48).dropna())
        x_axis = ['6 bulan terakhir', '6-12 bulan', '1-2 tahun', '2-4 tahun', '>4 tahun']
        y_axis = [recency6mos, recency6to12mos, recency1to2yr, recency2to4yr, recency4plusyr]
        rangedata = {'Bulan sejak terakhir mendonorkan darah': x_axis, 'Jumlah Pendonor': y_axis}
        df = pd.DataFrame(rangedata)

        #print(df)

        fig = px.bar(df, x = 'Bulan sejak terakhir mendonorkan darah', y = 'Jumlah Pendonor')
        fig.write_html('rfmrecency.html')


        #Buat Graph Frequency
        freq5 = len(data.where(data['Frequency'] < 5).dropna())
        freq5to10 = len(data.where((data['Frequency'] >= 5) & (data['Frequency'] <= 10)).dropna())
        freq10to20 = len(data.where((data['Frequency'] > 10) & (data['Frequency'] <= 20)).dropna())
        freq20to40 = len(data.where((data['Frequency'] > 20) & (data['Frequency'] <= 40)).dropna())
        freq40plus = len(data.where(data['Recency'] > 40).dropna())
        x_axis = ['<5 kali', '5-10 kali', '11-20 kali', '21-40 kali', '>40 kali']
        y_axis = [freq5, freq5to10, freq10to20, freq20to40, freq40plus]
        rangedata = {'Frekuensi pendonoran darah': x_axis, 'Jumlah Pendonor': y_axis}
        df = pd.DataFrame(rangedata)

        fig2 = px.bar(df, x='Frekuensi pendonoran darah', y='Jumlah Pendonor')
        fig2.write_html('rfmfrequency.html')

        #Buat Graph Monetary
        mon200 = len(data.where(data['Monetary'] < 200).dropna())
        mon2to4 = len(data.where((data['Monetary'] >= 200) & (data['Monetary'] <= 400)).dropna())
        mon4to6 = len(data.where((data['Monetary'] > 400) & (data['Monetary'] <= 600)).dropna())
        mon6to8 = len(data.where((data['Monetary'] > 600) & (data['Monetary'] <= 800)).dropna())
        mon800 = len(data.where(data['Monetary'] > 800).dropna())

        x_axis = ['<200cc', '200-400cc', '400-600cc', '600-800cc', '>800cc']
        y_axis = [freq5, freq5to10, freq10to20, freq20to40, freq40plus]
        rangedata = {'Total jumlah darah yang pernah didonorkan': x_axis, 'Jumlah Pendonor': y_axis}
        df = pd.DataFrame(rangedata)

        fig3 = px.bar(df, x='Total jumlah darah yang pernah didonorkan', y='Jumlah Pendonor')
        fig3.write_html('rfmmonetary.html')



        




except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        #print("MySQL connection is closed")

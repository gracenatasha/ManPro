from tkinter.messagebox import NO
from xml.etree.ElementTree import tostring
import mysql.connector
from mysql.connector import Error
from datetime import date

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

        #get max recency 
        recency_max = 0
        for i in recency_array: 
            if(i is not None): 
                if(i > recency_max): 
                    recency_max = i

        #get min recency
        recency_min = recency_max
        for i in recency_array: 
            if(i is not None): 
                if(i < recency_min): 
                    recency_min = i
        
        # print("max: ", recency_max, " min: ", recency_min)

        #min-max normalization to 0-5 (recency)
        normalized_recency_arr = []
        if(recency_max == recency_min): 
            for i in recency_array: 
                normalized_recency_arr.append(0)
        else: 
            for i in recency_array: 
                if(i is not None): 
                    normalized_recency_arr.append((i-recency_min)/(recency_max - recency_min)*5)
                else: 
                    normalized_recency_arr.append(None)

        print("r array: ", normalized_recency_arr)

except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        #print("MySQL connection is closed")

from tkinter.messagebox import NO
from xml.etree.ElementTree import tostring
import mysql.connector
from mysql.connector import Error
from datetime import date

try:
    connection = mysql.connector.connect(host='localhost',
                                         database='donor_darah2',
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
            sql_monetary = "SELECT max(jumlah_darah) FROM donor WHERE id_pendonor="+id_pendonor;
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


        #FREQUENCY-----------------------------
        frequency_array = []
        for pendonor in id_pendonor: 
            # print("Pendonor: ", pendonor[0])
            # print("freq: ", frequency(str(pendonor[0])))
            frequency_array.append(frequency(str(pendonor[0])))

        #get max frequency 
        frequency_max = 0
        for i in frequency_array: 
            if(i is not None): 
                if(i > frequency_max): 
                    frequency_max = i

        #get min frequency
        frequency_min = frequency_max
        for i in frequency_array: 
            if(i is not None): 
                if(i < frequency_min): 
                    frequency_min = i

        #min-max normalization to 0-5 (frequency)
        normalized_frequency_arr = []
        if(frequency_max == frequency_min): 
            for i in frequency_array: 
                normalized_frequency_arr.append(0)
        else: 
            for i in frequency_array: 
                if(i is not None): 
                    normalized_frequency_arr.append((i-frequency_min)/(frequency_max - frequency_min)*5)
                else: 
                    normalized_frequency_arr.append(0.0)

        print("freq: ", normalized_frequency_arr)


        #MONETARY------------------------------------------------------------
        monetary_array = []
        for pendonor in id_pendonor: 
            # print("Pendonor: ", pendonor[0])
            # print("mon: ", monetary(str(pendonor[0])))
            monetary_array.append(frequency(str(pendonor[0])))

        #get max frequency 
        monetary_max = 0
        for i in monetary_array: 
            if(i is not None): 
                if(i > monetary_max): 
                    monetary_max = i

        #get min frequency
        monetary_min = monetary_max
        for i in monetary_array: 
            if(i is not None): 
                if(i < monetary_min): 
                    monetary_min = i

        #min-max normalization to 0-5 (frequency)
        normalized_monetary_arr = []
        if(monetary_max == monetary_min): #kalo datanya sama, jd gabisa dicari minmax normalization nya
            for i in monetary_array: 
                normalized_monetary_arr.append(0)
        else: 
            for i in monetary_array: 
                if(i is not None): 
                    normalized_monetary_arr.append((i-monetary_min)/(monetary_max - monetary_min)*5)
                else: 
                    normalized_monetary_arr.append(0.0)

        print("mon: ", normalized_monetary_arr)


        #RFM-----------------------------------------
        rfm_arr = []
        for i in range(len(monetary_array)): 
            if(normalized_recency_arr[i] is None): 
                rfm_arr.append(0)
            else: 
                rfm_arr.append(normalized_recency_arr[i]+normalized_frequency_arr[i]+normalized_monetary_arr[i])

        print("rfm: ", rfm_arr)

except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        #print("MySQL connection is closed")

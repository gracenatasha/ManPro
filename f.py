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
        #function frequency
        def frequency(id_pendonor): 
            sql_frequency = "SELECT COUNT(id_donor) FROM `donor` WHERE id_pendonor = "+id_pendonor+" GROUP BY id_pendonor"; 
            cursor.execute(sql_frequency)
            freq = cursor.fetchone()

            if(freq is not None): 
                return freq[0]
            return 0

        #get all id pendonor
        sql_id_pendonor = "SELECT id_pendonor FROM `pendonor`"
        cursor.execute(sql_id_pendonor)
        id_pendonor = cursor.fetchall()

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
except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        #print("MySQL connection is closed")

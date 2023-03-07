# subscriber
import paho.mqtt.client as mqtt
import pymysql.cursors

# sql prameters
DatabaseHostName = '127.0.0.1'
DatabaseUserName = 'root'
DatabasePassword = ''
DatabaseName = 'energymeater'
DatabasePort = 3306

count = 0
data = {
	"temperature": "0",
  	"humidity":"0",
  	"heatIndex": "0",
  	"voltage": "0",
  	"current": "0",
  	"power": "0",
  	"frequency": "0"
}

print("Connecting to database")
connection = pymysql.connect(
	host = DatabaseHostName,
	user = DatabaseUserName,
	password = DatabasePassword,
	db = DatabaseName,
	charset = 'utf8mb4',
	cursorclass = pymysql.cursors.DictCursor,
	port = DatabasePort
)

# sql insertion function
def insertIntoDatabase():
	global data
	"Inserts the mqtt data into the database"
	with connection.cursor() as cursor:
		print("Inserting data: "+data["temperature"]+";"+data["humidity"]+";"+ data["heatIndex"]+";"+ data["voltage"]+";"+data["current"]+";"+ data["power"]+";"+data["frequency"])
		cursor.callproc('InsertIntoDevice_1', [str(data["temperature"]), str(data["humidity"]), str(data["heatIndex"]), str(data["voltage"]), str(data["current"]), str(data["power"]), str(data["frequency"])])
		connection.commit()

def combine(message):
	global count
	global data
	
	if(str(message.topic[14:]) == "temperature"):
		data["temperature"]=str(message.payload)[2:][:-1]
		count=1
	elif(str(message.topic[14:]) == "humidity"):
		data["humidity"]=str(message.payload)[2:][:-1]
		count=2
	elif(str(message.topic[14:]) == "heatIndex"):
		data["heatIndex"]=str(message.payload)[2:][:-1]
		count=3
	elif(str(message.topic[14:]) == "voltage"):
		data["voltage"]=str(message.payload)[2:][:-1]
		count=4
	elif(str(message.topic[14:]) == "current"):
		data["current"]=str(message.payload)[2:][:-1]
		count=5
	elif(str(message.topic[14:]) == "power"):
		data["power"]=str(message.payload)[2:][:-1]
		count=6
	elif(str(message.topic[14:]) == "frequency"):
		data["frequency"]=str(message.payload)[2:][:-1]
		count=7
	if(count == 7):
			count = 0
			if(data["temperature"]!="nan" and data["humidity"]!="nan" and data["heatIndex"]!="nan" and data["voltage"]!="nan" and data["current"]!="nan" and data["power"]!="nan" and data["frequency"]!="nan"):
				insertIntoDatabase()	


def on_connect(client, userdata, flags, rc):
    print("Connected to a broker!")

def on_message(client, userdata, message):
    # print("Received message '" + str(message.payload)[2:][:-1] + "' on topic '"+ message.topic + "' with QoS " + str(message.qos))
	combine(message)
    # print(message.payload.decode())

def on_message_msgs(mosq, obj, msg):
    # This callback will only be called for messages with topics that match
	combine(msg)
	# insertIntoDatabase(msg)


client = mqtt.Client()

# connect to mqttt broker
client.connect('broker.hivemq.com', 1883)
client.subscribe("data/energy/#", 0)

# while True:
client.on_connect = on_connect
client.on_message = on_message
# loop untill message comes
client.loop_forever()
#include "config.h"
#include <DHT.h>

// energy meter
#include <SDM.h>  

#define ESP32 //import SoftwareSerial library
#if defined ( ESP8266 ) || defined ( ESP32 )                                    //for ESP
SoftwareSerial swSerSDM;                                                        //config SoftwareSerial
SDM sdm(swSerSDM, 9600, 22, SWSERIAL_8N1, 26, 27);       //config SDM
#else                                                                           //for AVR
SoftwareSerial swSerSDM(SDM_RX_PIN, SDM_TX_PIN);                                //config SoftwareSerial
SDM sdm(swSerSDM, SDM_UART_BAUD, NOT_A_PIN);                                             //config SDM

#endif

#include <SoftwareSerial.h>  


   
// wifi
#include <WiFi.h>
WiFiClient espClient;

// MQTT
#include <PubSubClient.h>
PubSubClient client(espClient);

// DHT sensor
DHT dht(pinDHT, DHT11);

unsigned long currentMillis = 0;
unsigned long previousMillis = 0;

unsigned long currentMillis2 = 0;
unsigned long previousMillis2 = 0;

char buffer[64];
 
float temperature = 0;
float humidity = 0;
float heatIndex = 0;

float voltage = 0;
float current = 0;
float power = 0;
float frequency = 0;

// Callback funceader
void callback(char* topic, byte* payload, unsigned int length);



void connectWifi() {
  Serial.println("Connecting to WiFi...");
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("WiFi connected");
}

void connectMqtt() {
  Serial.println("Connecting to MQTT...");
  client.setServer(MQTT_HOST, MQTT_PORT);

  while (!client.connected()) {
    if (!client.connect(MQTT_CLIENTID, MQTT_USERNAME, MQTT_PASSWORD)) {
      Serial.print("MQTT connection failed:");
      Serial.print(client.state());
      Serial.println("Retrying...");
      delay(5000);
    }
  }
  client.subscribe((MQTT_BASE_TOPIC + "machine1").c_str());
  client.subscribe((MQTT_BASE_TOPIC + "machine2").c_str());

  Serial.println("MQTT connected");
  Serial.println("");
}

// Callback function
void callback(char* topic, byte* payload, unsigned int length) {

  //  on off the machines
  if (!strcmp(topic, machine1)){      
      if (!strncmp((char *)payload, "1", length)){              // on
          digitalWrite(pinMachine1, LOW);
      }
      else if (!strncmp((char *)payload, "0", length)){ // off
        digitalWrite(pinMachine1, HIGH);
      }

  }
  if (!strcmp(topic, machine2)){
      if (!strncmp((char *)payload, "1", length)){          // on
        digitalWrite(pinMachine2, LOW);
      }
      else if (!strncmp((char *)payload, "0", length)){ // off
        digitalWrite(pinMachine2, HIGH);
      }
  }
}

void readSensorData(){
  
 // Reading temperature or humidity takes about 250 milliseconds!
// humidity = dht.readHumidity();
 humidity = 35;
 // Read temperature as Celsius (the default)
// temperature = dht.readTemperature();
temperature = 40;
 // Check if any reads failed and exit early (to try again).
 if (isnan(humidity) || isnan(temperature)) {
   Serial.println(F("Failed to read from DHT sensor!"));
   return;
 }
// heatIndex = dht.computeHeatIndex(temperature, humidity, false);
heatIndex = 12;
  Serial.print(F("Humidity: "));
  Serial.print(humidity);
  Serial.print(F("%  Temperature: "));
  Serial.print(temperature);
  Serial.print(F("°C "));
  Serial.print(F("Heat index: "));
  Serial.print(heatIndex);
  Serial.print(F("°C "));

//  voltage = sdm.readVal(SDM_PHASE_1_VOLTAGE);
//  current = sdm.readVal(SDM_PHASE_1_CURRENT);
//  power = sdm.readVal(SDM_PHASE_1_POWER);
//  frequency = sdm.readVal(SDM_FREQUENCY);
  voltage = 230;
  current = 12;
  power = 57;
  frequency = 38;
  Serial.print("\nvoltage");
  Serial.print(voltage);
  Serial.print("\ncurrent");
  Serial.print(current);
  Serial.print("\npower");
  Serial.print(power);
  Serial.print("\nfrequency");
  Serial.print(frequency);

}

void sendSensorData() {
 
  if (!client.connected())
    connectMqtt();
 
  snprintf(buffer, 64, "%f", temperature);
  client.publish((MQTT_BASE_TOPIC + "temperature").c_str(), buffer); 
  snprintf(buffer, 64, "%f", humidity);
  client.publish((MQTT_BASE_TOPIC + "humidity").c_str(), buffer); 
  snprintf(buffer, 64, "%f", heatIndex);
  client.publish((MQTT_BASE_TOPIC + "heatIndex").c_str(), buffer); 
  
  snprintf(buffer, 64, "%f", voltage);
  client.publish((MQTT_BASE_TOPIC + "voltage").c_str(), buffer); 
  snprintf(buffer, 64, "%f", current);
  client.publish((MQTT_BASE_TOPIC + "current").c_str(), buffer); 
  snprintf(buffer, 64, "%f", power);
  client.publish((MQTT_BASE_TOPIC + "power").c_str(), buffer); 
  snprintf(buffer, 64, "%f", frequency);
  client.publish((MQTT_BASE_TOPIC + "frequency").c_str(), buffer); 

  
}



void setup() {

  Serial.begin(115200);

  sdm.begin(); 
  
  //  relay modules
  pinMode(pinMachine1, OUTPUT);
  pinMode(pinMachine2, OUTPUT);
  digitalWrite(pinMachine1, HIGH);
  digitalWrite(pinMachine2, HIGH);

//  dht.begin();
    
  // MQTT Subscibe callback function
  client.setCallback(callback);

  // connecting wifi and mqtt server
  connectWifi();
  connectMqtt();
  
 
}

void loop() {  

  // MQTT subcriber
  client.loop();

  currentMillis = millis();
  if (currentMillis - previousMillis > 2000) {
    readSensorData();
    sendSensorData();
    previousMillis = currentMillis;
  }


 
}


// WiFi
const char*   WIFI_SSID       = "Dialog Home Wi-Fi";
const char*   WIFI_PASSWORD   = "mypassword1";

// MQTT 
const char*   MQTT_HOST       = "broker.hivemq.com";
const int     MQTT_PORT       = 1883;
const char*   MQTT_CLIENTID   = "MQTT_FX_Client";
const char*   MQTT_USERNAME   = "";
const char*   MQTT_PASSWORD   = "";
const String  MQTT_BASE_TOPIC = "data/energy/1/"; 

// machines
const char* machine1  = "data/energy/1/machine1";
const char* machine2  = "data/energy/1/machine2";

#define pinMachine1 13
#define pinMachine2 14
#define pinDHT 5

import time
import paho.mqtt.client as mqtt
import json, time, random
import threading


# Paramètres de connexion à compléter
# Nom du groupe sans espaces avec la nomenclature WEB2 ou WEB3
# Exemple : WEB2-GROUPE3
GROUPNAME = "WEB3-GROUPE8"

MQTT_BROKER = "hetic.arcplex.fr"

# Login et mot de passe du groupe
MQTT_USERNAME = "ARCHITECH"
MQTT_PASSWORD = "64593502"
# un ID différent par Node
NODE_ID = [
    "042101",
    "042102",
    "042103",
    "042104",
    "042105",
    "042202",
    "042303",
    "042204",
    "042106",
    "042107",
    "042108",
    "042109",
    "042110",
    "042205",
    "042206",
    "042207",
    "042208",
    "042209",
    "042210",
    "042301",
    "042302",
    "042304",
]
# ID du sensor
SENSOR_ID_PRESS = 116
SENSOR_ID_TEMP = 112
SENSOR_ID_HUMY = 114

# Type de donnée renvoyée : Random 0 ou 1
VALMINPRESS = 970
VALMAXPRESS = 1050
VALMINTEMP = 28
VALMAXTEMP = 29
VALMINHUMY = 0
VALMAXHUMY = 100

client = mqtt.Client("client")
client.username_pw_set(username=MQTT_USERNAME, password=MQTT_PASSWORD)


def task():
    client.connect(MQTT_BROKER)
    for node in NODE_ID:
        # PREESSURE
        MQTT_TOPIC_PRESS = GROUPNAME + "/" + node + "/" + str(SENSOR_ID_PRESS)
        MQTT_MSG_PRESS = json.dumps(
            {
                "source_address": node,
                "sensor_id": SENSOR_ID_PRESS,
                "tx_time_ms_epoch": int(time.time()),
                "data": {"value": round(random.uniform(VALMINPRESS, VALMAXPRESS), 2)},
            }
        )
        client.publish(MQTT_TOPIC_PRESS, MQTT_MSG_PRESS)

        # TEMPERATURE
        MQTT_TOPIC_TEMP = GROUPNAME + "/" + node + "/" + str(SENSOR_ID_TEMP)
        MQTT_MSG_TEMP = json.dumps(
            {
                "source_address": node,
                "sensor_id": SENSOR_ID_TEMP,
                "tx_time_ms_epoch": int(time.time()),
                "data": {"value": round(random.uniform(VALMINTEMP, VALMAXTEMP), 2)},
            }
        )
        client.publish(MQTT_TOPIC_TEMP, MQTT_MSG_TEMP)

        # HUMIDITY
        MQTT_TOPIC_HUMY = GROUPNAME + "/" + node + "/" + str(SENSOR_ID_HUMY)
        MQTT_MSG_HUMY = json.dumps(
            {
                "source_address": node,
                "sensor_id": SENSOR_ID_HUMY,
                "tx_time_ms_epoch": int(time.time()),
                "data": {"value": round(random.uniform(VALMINHUMY, VALMAXHUMY), 2)},
            }
        )
        client.publish(MQTT_TOPIC_HUMY, MQTT_MSG_HUMY)
        print("MQTT Mis à jour - Node %s Timestamp : %s" % (node, int(time.time())))


def executeTask():
    threading.Timer(300.0, executeTask).start()
    task()


executeTask()

import mqtt from "mqtt";
import levelStore from "mqtt-level-store";
import config from "../config";

export default class Chat {
    constructor(id) {
        const manager = levelStore('./chatter-tzsk/chats');
        this.client = mqtt.connect({
            ...config.MQTT,
            clientId: id,
            // incomingStore: manager.incoming,
            // outgoingStore: manager.outgoing,
        });
    }

    send(topic, message) {
        this.client.publish(topic, JSON.stringify(message), {
            qos: 2
        });
    }
}

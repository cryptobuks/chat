import mqtt from "mqtt";
import config from "../config";

export default class Chat {
    constructor(id) {
        this.client = mqtt.connect({
            ...config.MQTT,
            clientId: id,
        });
    }

    send(topic, message) {
        this.client.publish(topic, JSON.stringify(message), {
            qos: 2
        });
    }
}

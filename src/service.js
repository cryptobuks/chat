import axios from "axios";
import config from "./config";
import auth from "./auth";

class Service {
    constructor() {
        this.config = {
            baseURL: 'http://localhost/chatter/public/api/',
            headers: {
                'x-api-key': config.API_KEY,
            }
        };
    }

    api() {
        return axios.create(this.config);
    }

    auth() {
        return axios.create({
            ...this.config, 
            headers: {
                'X-Api-Key': config.API_KEY,
                'Authorization': 'Bearer ' + auth.user().api_token
            }
        });
    }

    web() {
        return axios.create({
            ...this.config,
            baseURL: 'http://localhost/chatter/public/'
        });
    }
}

export default new Service;

import axios from "axios";
import config from "../config";
import auth from "./auth";

class Service {
    constructor() {
        this.config = {
            baseURL: config.API_BASE_URL,
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
            baseURL: config.WEB_BASE_URL
        });
    }
}

export default new Service;

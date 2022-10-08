import axios from "axios";
import { storeToRefs } from "pinia";
import { useUserStore } from "../stores/user";

const api_url = location.protocol + "//" + location.hostname + "/api";

const getHeaders = () => {
    const store = useUserStore();
    const { token } = storeToRefs(store);

    return {
        Authorization: `Bearer ${token.value}`,
    };
};

export const get = (url) => {
    return axios.get(`${api_url}${url}`, { headers: getHeaders() });
};

export const post = (url, data) => {
    return axios.post(`${api_url}${url}`, data, { headers: getHeaders() });
};

export const put = (url, data) => {
    return axios.put(`${api_url}${url}`, data, { headers: getHeaders() });
};

export const del = (url) => {
    return axios.delete(`${api_url}${url}`, { headers: getHeaders() });
};

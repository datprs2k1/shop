import axios from "axios";

const api_url = location.protocol + "//" + location.hostname + "";

const getHeaders = () => {
    let token = localStorage.getItem("token");
    return {
        Authorization: `Bearer ${token}`,
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

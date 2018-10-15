import { setAuthorization } from "./init";

export function login(credentials) {
    return new Promise((resolve, reject) => {
        axios.post('/api/login', credentials)
            .then((response) => {
                setAuthorization(response.data.access_token);
                resolve(response.data);
            })
            .catch((error) => {
                reject("Username atau Password Salah");
            })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem("user");

    if(!userStr) {
        return null;
    }

    return JSON.parse(userStr);
}
import { setAuthorization } from "./init";

export function login(credentials) {
    return new Promise((resolve, reject) => {
        // mengirim post request dengan membawa data (username dan password)
        axios.post('/api/login', credentials)
            // login sukses
            .then((response) => {
                // menyimpan akses token
                setAuthorization(response.data.access_token);
                // menyimpan info user
                resolve(response.data);
            })
            // login gagal
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
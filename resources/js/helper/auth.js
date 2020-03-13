export function login(credentials) {
    return new Promise((res, rej) => {
        csrf().then(response => {
            axios.post('/api/login', credentials)
                .then((response) => {

                })
                .catch((errors) => {

                });
        });
    });
}

export function csrf() {
    return axios.get('/airlock/csrf-cookie');
}

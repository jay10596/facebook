class Storage {
    store(token, username) {
        this.storeToken(token)
        this.storeUsername(username)
    }

    storeToken(token) {
        localStorage.setItem('token', token)
    }

    storeUsername(username) {
        localStorage.setItem('username', username)
    }

    clear() {
        localStorage.removeItem('token')
        localStorage.removeItem('username')
    }

    getToken() {
        return localStorage.getItem('token')
    }

    getUsername() {
        return localStorage.getItem('username')
    }
}

export default Storage = new Storage();

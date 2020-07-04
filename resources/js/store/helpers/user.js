import Token from './token'
import Storage from './storage'

class User {
    responseAfterLogin(res) {
        const token = res.data.access_token
        const username = res.data.name

        if(Token.isValid(token))
        {
            Storage.store(token, username)

            window.location = "/" //it refreshes the app without the hard refresh and redirects to '/'
        }
    }

    hasToken() {
        const storedToken = Storage.getToken()

        if(storedToken){
            return Token.isValid(storedToken) ? true : this.logout()
        }

        return false
    }

    loggedIn() {
        return this.hasToken()
    }

    logout(){
        Storage.clear()

        window.location = "/"
    }

    name() {
        if(this.loggedIn()){
            return Storage.getUsername()
        }
    }

    id() { //id is the sub: part of the payload
        if(this.loggedIn()){
            const payload = Token.getPayload(Storage.getToken())
            return payload.sub
        }
    }

    own(id) {
        return this.id() == id
    }

    admin() {
        return this.id() == 10
    }
}

export default User = new User();

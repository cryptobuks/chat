export default class GoogleUser {
    constructor(user, token) {
        this.id = user.uid;
        this.name = user.displayName;
        this.image = user.photoURL;
        this.email = user.email;
        this.token = token;
    }
}
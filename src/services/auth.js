class Auth {
    constructor() {
        this.key = 'loggedInUser';
        this.digest();
    }

    digest() {
        this.checkAuth = false;
        this.authUser = {api_token: null};
        if (window.sessionStorage.getItem(this.key)) {
            this.checkAuth = true;
            this.authUser = JSON.parse(window.sessionStorage.getItem(this.key));
        }
    }

    user() {
        return this.authUser;
    }

    check() {
        return this.checkAuth;
    }

    login(user) {
        window.sessionStorage.setItem(this.key, JSON.stringify(user));
        this.digest();
    }

    logout() {
        window.sessionStorage.removeItem(this.key);
    }
}

export default new Auth;
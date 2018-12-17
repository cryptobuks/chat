<template>
    <div class="flex flex-col h-full items-center justify-center">
        <div class="w-1/2 rounded bg-white text-grey-darkest shadow">
            <div class="p-4 border-solid border-b border-grey-light text-center">
                Start using the chat by signing in
            </div>
            <div class="p-4 flex justify-center" v-if="!user">
                <button class="py-3 px-8 bg-red-dark rounded shadow text-white flex items-center" @click="loginWithGoogle">
                    <i class="fab fa-google mr-2"></i>
                    Sign in with Google
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import firebase from '../firebase';
import User from '../user';
import { mapActions, mapState } from 'vuex';

export default {
    computed: {
        googleProvider() {
            return new firebase.auth.GoogleAuthProvider();
        },
        ...mapState(['user'])
    },
    methods: {
        loginWithGoogle() {
            firebase.auth().signInWithPopup(this.googleProvider).then((result) => {
                let token = result.credential.accessToken;
                let user = result.user;
                let theUser = new User(user, token);

                window.sessionStorage.setItem('loggedInUser', JSON.stringify(theUser));
                this.loginUser(theUser);
            }).catch(function(error) {
                // eslint-disable-next-line
                console.log(error);
            });
        },
        ...mapActions(['loginUser'])
    }
};
</script>

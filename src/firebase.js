import firebase from 'firebase';

const config = {
    apiKey: "AIzaSyBE3IjvbZHqMGgdBN9XBefD-nAVX6H1AtE",
    authDomain: "vue-chat-tzsk.firebaseapp.com",
    databaseURL: "https://vue-chat-tzsk.firebaseio.com",
    projectId: "vue-chat-tzsk",
    storageBucket: "vue-chat-tzsk.appspot.com",
    messagingSenderId: "94864749152"
};

firebase.initializeApp(config);

export default firebase;
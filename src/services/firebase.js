import firebase from 'firebase';
import config from '../config';

firebase.initializeApp(config.FIREBASE);

export default firebase;
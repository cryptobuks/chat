import auth from '../../auth';
import service from '../../service';

export default {
    loginUser(context, user) {
        service.api().post('users', user).then((response) => {
            let user = response.data.data;
            auth.login(user);
            context.commit('login', user);
        }).catch((error) => {
            console.log(error);
        });
    },
    logOutUser(context) {
        auth.logout();
        context.commit('logout');
    },
}
import auth from '../../auth';
import service from '../../service';

export default {
    loginUser(context, user) {
        context.commit('wait', true);
        service.api().post('users', user).then((response) => {
            let user = response.data.data;
            auth.login(user);
            context.commit('login', user);
            context.commit('wait', false);
        }).catch((error) => {
            console.log(error);
            context.commit('wait', false);
        });
    },
    logOutUser(context) {
        auth.logout();
        context.commit('logout');
    },
}
import {getInfo} from '../../api/user'

const state = {
    isLogin: false,//是否登录
    isVip: false,
    username: "",
    avatar: "",
    unreadNotificationCount: 0,
    integral: 0,
    balance: 0.0,
    google_adsense_client: '',
    qq_client_id: '',
    weibo_client_id: '',
    userinfo: {}
};

const mutations = {
    SET_INFO(state, info) {
        state.userinfo = info;
        state.isLogin = info.isLogin;
        state.username = info.username;
        state.avatar = info.avatar;
        state.integral = info.integral;
        state.balance = info.balance;
        state.unreadNotificationCount = info.unreadNotificationCount;
    },
};

const actions = {
    init({dispatch, commit}) {
        return new Promise((resolve, reject) => {
            getInfo().then(response => {
                commit('SET_INFO', response);
                resolve(response)
            }).catch(error => {
                reject(error)
            });
        });
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
}

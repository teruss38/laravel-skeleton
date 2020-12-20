import {getInfo} from '../../api/user'

const state = {
    isLogin: false,//是否登录
    username: "",
    avatar: "",
    unreadNotificationCount: 0,
    integral: 0,
    balance: 0.0,
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

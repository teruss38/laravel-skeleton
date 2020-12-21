const getters = {
    isLogin: state => state.app.isLogin,
    isVip: state => state.app.isVip,
    username: state => state.app.username,
    avatar: state => state.app.avatar,
    unreadNotificationCount: state => state.app.unreadNotificationCount,
    integral: state => state.app.integral,
    balance: state => state.app.balance,
    userinfo: state => state.app.userinfo,
    adsense_client: state => state.app.google_adsense_client,
};
export default getters

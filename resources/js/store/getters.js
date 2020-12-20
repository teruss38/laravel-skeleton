const getters = {
    isLogin: state => state.app.isLogin,
    username: state => state.app.username,
    avatar: state => state.app.avatar,
    unreadNotificationCount: state => state.app.unreadNotificationCount,
    integral: state => state.app.integral,
    balance: state => state.app.balance,
    userinfo: state => state.app.userinfo
};
export default getters

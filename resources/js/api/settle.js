import request from './request'


/**
 * 获取结算账户
 * @returns {AxiosPromise}
 */
const getAccounts = function (page) {
    return request({
        method: 'get',
        url: '/api/v1/user/settle',
        params: {
            page: page
        }
    });
};

/**
 * 添加结算账户
 * @returns {AxiosPromise}
 */
const addAccount = function (data) {
    return request({
        method: 'post',
        url: '/api/v1/user/settle',
        data: data
    });
};

/**
 * 删除结算账户
 * @returns {AxiosPromise}
 */
const deleteAccount = function (id) {
    return request({
        method: 'post',
        url: '/api/v1/user/settle/' + id,
        data: {_method: 'DELETE'}
    });
};

export {
    getAccounts, addAccount, deleteAccount,
}

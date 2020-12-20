import request from './request'

/**
 * 获取付款状态
 * @param id
 * @returns {AxiosPromise}
 */
const getCharge = function (id) {
    return request({
        method: 'get',
        url: '/transaction/charge/' + id
    });
};

export {
    getCharge
}

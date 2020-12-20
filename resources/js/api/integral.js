import request from './request'

/**
 * 获取交易明细
 * @param page
 * @returns {AxiosPromise}
 */
const getTransactions = function (page) {
    return request({
        method: 'get',
        url: '/api/v1/user/integral/transactions',
        params: {
            page: page
        }
    });
};

/**
 * 充值申请
 * @param channel
 * @param amount
 * @param type
 * @returns {AxiosPromise}
 */
const recharge = function (channel, amount, type) {
    return request({
        method: 'post',
        url: '/api/v1/user/integral/recharge',
        data: {
            channel: channel,
            amount: amount * 100,
            type: type
        }
    });
};

/**
 * 提现申请
 * @returns {AxiosPromise}
 * @param coin
 * @param recipient
 */
const withdrawals = function (coin, recipient) {
    return request({
        method: 'post',
        url: '/api/v1/user/integral/withdrawals',
        data: {
            integral: integral,
            recipient_id: recipient
        }
    });
};

export {
    getTransactions,
    recharge,
    withdrawals
}

import request from './request'

/**
 * 获取余额交易明细
 * @param page
 * @returns {AxiosPromise}
 */
const getTransactions = function (page) {
    return request({
        method: 'get',
        url: '/api/v1/user/wallet/transactions',
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
        url: '/api/v1/user/wallet/recharge',
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
 * @param amount
 * @param recipient
 */
const withdrawals = function (amount, recipient) {
    return request({
        method: 'post',
        url: '/api/v1/user/wallet/withdrawals',
        data: {
            amount: amount,
            recipient_id: recipient
        }
    });
};

export {
    getTransactions,
    recharge,
    withdrawals
}

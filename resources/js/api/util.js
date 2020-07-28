import request from './request'
/**
 * 获取国家列表
 * @returns {AxiosPromise}
 */
const getCountry = function () {
    return request({
        method: 'get',
        url: '/api/country'
    });
};

/**
 * 获取短信验证码
 * @param phone
 * @param ticket
 * @param randstr
 * @returns {AxiosPromise}
 */
const getPhoneVerifyCode = function (phone, ticket, randstr) {
    return request({
        method: 'post',
        url: '/api/phone-verify-code',
        data: {
            phone: phone,
            ticket: ticket,
            randstr: randstr
        }
    });
};

/**
 * 获取邮箱验证码
 * @param email
 * @param ticket
 * @param randstr
 * @returns {AxiosPromise}
 */
const getEmailVerifyCode = function (email, ticket, randstr) {
    return request({
        method: 'post',
        url: '/api/mail-verify-code',
        data: {
            email: email,
            ticket: ticket,
            randstr: randstr
        }
    });
};

export {
    getCountry,
    getPhoneVerifyCode,
    getEmailVerifyCode
}

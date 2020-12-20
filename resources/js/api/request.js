import axios from 'axios'
import {Message, MessageBox} from 'element-ui';

const CSRFToken = document.head.querySelector('meta[name="csrf-token"]');

// create an axios instance
const service = axios.create({
    //baseURL: process.env.MIX_APP_URL, // url = base url + request url
    //withCredentials: true, // send cookies when cross-domain requests
    timeout: 5000, // request timeout
});

// request interceptor
service.interceptors.request.use(
    config => {
        config.headers['X-Requested-With'] = 'XMLHttpRequest';
        // do something before request is sent
        if (CSRFToken) {
            // let each request carry token
            // ['X-CSRF-TOKEN'] is a custom headers key
            // please modify it according to the actual situation
            config.headers['X-CSRF-TOKEN'] = CSRFToken.content
        } else {
            //console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
        return config
    },
    error => {
        // do something with request error
        //console.warn(error);// for debug
        return Promise.reject(error)
    }
);

// response interceptor
service.interceptors.response.use(
    /**
     * If you want to get http information such as headers or status
     * Please return  response => response
     */

    /**
     * Determine the request status by custom code
     * Here is just an example
     * You can also judge the status by HTTP Status Code
     */
    response => {
        return response.data;
    },
    error => {
        if (error.response) {
            if (error.response.status === 400) {
                Message({
                    message: error.response.data.message || '客户端错误！',
                    type: 'warning',
                    duration: 3 * 1000
                });
            } else if (error.response.status === 401) {
                MessageBox.confirm('您的登录已过期，重新登录?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    window.location.href="/login?ref="+window.location.href;
                }).catch(() => {});
                // Message({
                //     message: error.response.data.message || '您的登录已过期，请重新登录！',
                //     type: 'warning',
                //     duration: 3 * 1000
                // });
            } else if (error.response.status === 403) {
                Message({
                    message: error.response.data.message || '您的权限不足！',
                    type: 'warning',
                    duration: 3 * 1000
                });
            } else if (error.response.status === 404) {
                Message({
                    message: error.response.data.message || '请求的资源不存在！',
                    type: 'warning',
                    duration: 3 * 1000
                });
            } else if (error.response.status === 405) {
                Message({
                    message: error.response.data.message || '服务器不支持该请求！',
                    type: 'warning',
                    duration: 3 * 1000
                });
            } else if (error.response.status === 419) {
                Message({
                    message: error.response.data.message || '该页面已经过期，请刷新页面重试！',
                    type: 'warning',
                    duration: 3 * 1000
                });
            } else if (error.response.status === 429) {
                Message({
                    message: error.response.data.message || '您的操作太快了，请稍后再试！',
                    type: 'warning',
                    duration: 3 * 1000
                });
            } else if (error.response.status === 500) {
                Message({
                    message: error.response.data.message || '服务器发生了一个始料未及的错误，请稍后再试！',
                    type: 'error',
                    duration: 3 * 1000
                });
            } else {
                Message({
                    message: error.response.data.message || '服务器繁忙，请稍后再试！',
                    type: 'error',
                    duration: 3 * 1000
                });
            }
        } else if (error.message.includes('timeout')) {
            Message({
                message: '请求超时，请检查网络连接!',
                type: 'error',
                duration: 3 * 1000
            })
        } else if (error.message.includes('Network Error')) {
            Message({
                message: '网络错误，请检查网络连接!',
                type: 'error',
                duration: 3 * 1000
            })
        }
        return Promise.reject(error)
    }
);
export default service

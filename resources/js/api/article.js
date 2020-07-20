import request from './request'

const getCategories = function () {
    return request({
        method: 'get',
        url: '/api/v1/articles/categories',
    });
}

const getArticles = function () {
    return request({
        method: 'get',
        url: '/api/v1/articles'
    });
};

const getArticle = function (id) {
    return request({
        method: 'get',
        url: '/api/v1/articles/' + id,
    });
}

export {
    getCategories,
    getArticles,
    getArticle,

}

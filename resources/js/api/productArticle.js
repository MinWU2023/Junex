import http from '../libs/http'

export const getAllCategories = (id) => {
    return http.get(`/article/getAllArticles/` + id)
}

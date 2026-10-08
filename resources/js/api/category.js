import http from '../libs/http'

export const getAllCategories = (id,type) => {
    if (type === 'product'){
        return http.get(`/product/category/getAllCategories/` + id)
    } else {
        return http.get(`/product/attribute/category/getAllCategories/` + id)
    }
}

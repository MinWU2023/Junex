import http from '../libs/http'

export const getAllAttribute = (id) => {
    return http.get(`/product/attribute/all/` + id)
}

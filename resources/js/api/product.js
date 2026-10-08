import http from '../libs/http'

export const getAllProducts = (id) => {
    return http.get(`/coupon/getAllProducts/` + id)
}

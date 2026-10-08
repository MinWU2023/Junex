import http from '../libs/http'

export const getAllPemissions = () => {
    return http.get(`getAllPermissions`)
}

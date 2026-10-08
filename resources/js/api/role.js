import http from '../libs/http'

export const roleAssignPermission = (id, permissions) => {
    return http.put(`/api/role/${id}/permissions`, {
        permissions
    })
}

export const rolePermission = (id) => {
    return http.get(`role/${id}/permissions`)
}

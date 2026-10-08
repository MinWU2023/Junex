import axios from 'axios'

const httpRequest = axios.create({
    baseURL: '/' + process.env.MIX_ADMIN_PREFIX + '/',
    timeout: 60000,
})

httpRequest.interceptors.request.use(
    config => {
        return config
    },
    error => {
        return Promise.reject(error)
    }
)

export function setHttpToken (token) {
    // httpRequest.defaults.headers.common.Authorization = `Bearer ${token}`
}

export default httpRequest

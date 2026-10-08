import http from '../libs/http'

export const getAllTags = (type) => {
    if (type==='product'){
        return http.get(`getAllProductTags`)
    }else{
        return http.get(`getAllBlogTags`)
    }
}


export const keywordsSearch = (keywords) => {
        return http.get(`product/keywords/`+keywords)
}


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.Vue = require('vue');
window.ElementUI = require('element-ui');
require('element-ui/lib/theme-chalk/index.css')

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('permission-component', require('./components/PermissionComponent.vue').default);
Vue.component('category-component', require('./components/CategoryComponent.vue').default);
Vue.component('product-article-component', require('./components/ProductArticleComponent.vue').default);
Vue.component('tag-component', require('./components/TagComponent.vue').default);
Vue.component('coupon-select-product', require('./components/CouponSelectProductComponent.vue').default);
Vue.component('attribute-component', require('./components/AttributeComponent.vue').default);
Vue.component('universal-component', require('./components/UniversalComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(ElementUI)

 new Vue({
    el: '#app'
});

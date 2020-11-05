/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment')
import VueSweetalert2 from 'vue-sweetalert2';


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
//Students
Vue.component('student-list-component', require('./components/student/StudentListComponent.vue').default);
Vue.component('student-create-component', require('./components/student/StudentCreateComponent.vue').default);
Vue.component('student-edit-component', require('./components/student/StudentEditComponent.vue').default);
//Adresses
Vue.component('adress-list-component', require('./components/adress/AdressListComponent.vue').default);
Vue.component('adress-create-component', require('./components/adress/AdressCreateComponent.vue').default);
Vue.component('adress-edit-component', require('./components/adress/AdressEditComponent.vue').default);
//Classrooms
Vue.component('classroom-list-component', require('./components/classroom/ClassroomListComponent.vue').default);
Vue.component('classroom-create-component', require('./components/classroom/ClassroomCreateComponent.vue').default);
Vue.component('classroom-edit-component', require('./components/classroom/ClassroomEditComponent.vue').default);
//Registrations
Vue.component('registration-list-component', require('./components/registration/RegistrationListComponent.vue').default);
Vue.component('registration-create-component', require('./components/registration/RegistrationCreateComponent.vue').default);
Vue.component('registration-edit-component', require('./components/registration/RegistrationEditComponent.vue').default);

Vue.use(VueSweetalert2);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 * 
 * 
 */

Vue.prototype.$csrf_token = document.querySelector('meta[name="csrf-token"]').content
Vue.prototype.$via_cep = "https://viacep.com.br/ws/"


const app = new Vue({
    el: '#app',
});

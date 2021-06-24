require('./bootstrap');

import Vue from "vue";
import Toasted from 'vue-toasted';
import Multiselect from 'vue-multiselect'
import VueModal from '@kouts/vue-modal'

import 'vue-multiselect/dist/vue-multiselect.min.css'
import '@kouts/vue-modal/dist/vue-modal.css'

Vue.prototype.$user = window.User

Vue.use(Toasted, {
    duration: 3000
})

Vue.component('Modal', VueModal)
Vue.component('multiselect', Multiselect)

Vue.component('cases-list', require('./app/cases/CasesList.vue').default)

const app = new Vue({
    el: '#app',
});

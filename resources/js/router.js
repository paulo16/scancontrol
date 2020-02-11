import Vue from 'vue'
import VueRouter from 'vue-router'
import vMultiselectListbox from 'vue-multiselect-listbox'

Vue.component('v-multiselect-listbox', vMultiselectListbox)
Vue.use(VueRouter);
/*
    Import des composants
 */
import Home from './components/Home.vue';
//import Scan from './components/Scan.vue';
import Scanpdf from './components/Scanpdf.vue';

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/scanpdf',
      name: 'Scanpdf',
      component: Scanpdf
    }
  ]
})

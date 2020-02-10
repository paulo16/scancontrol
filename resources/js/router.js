import Vue from 'vue'
import VueRouter from 'vue-router'
import vMultiselectListbox from 'vue-multiselect-listbox'

Vue.component('v-multiselect-listbox', vMultiselectListbox)
Vue.use(VueRouter);
/*
    Import des composants
 */
import Home from './components/Home.vue';

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    }
  ]
})

require('./bootstrap');

import Vue from 'vue'
import App from './App.vue'

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    render: h => h(App),
}).$mount('#app');



require('./bootstrap');

window.Vue = require('vue').default;

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);


import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('Pareto', require('./components/Grafico_A.vue').default);

Vue.component('Bihoral', require('./components/Grafico_B.vue').default);

Vue.component('Grafico2', require('./components/Grafico_C.vue').default);

Vue.component('Playera', require('./components/Grafico_D.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    
});

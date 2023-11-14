require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);


import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)






Vue.component('apexchart', VueApexCharts)

Vue.component('Dashboard', require('./components/Dashboard.vue').default);


/***************Calidad************************/

Vue.component('Calidad', require('./components/ExampleComponent.vue').default);

Vue.component('Pareto', require('./components/Grafico_A.vue').default);

Vue.component('Grafico2', require('./components/Grafico_C.vue').default);

Vue.component('Playera', require('./components/Grafico_D.vue').default);

/*************Produccion***************/
Vue.component('Produccion', require('./components/Produccion.vue').default);
Vue.component('Bihoral', require('./components/Grafico_B.vue').default);
Vue.component('Grafico-Bihoral', require('./components/Grafico_F.vue').default);


const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    
});


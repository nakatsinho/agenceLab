import { createApp } from 'vue'
import { createPinia } from 'pinia'
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
 

import App from './AppScope.vue'
// import Auth from './AuthScope.vue'
// import Toasted from 'vue-toasted';


import router from './router'

const app = createApp(App)

DataTable.use(DataTablesCore);
app.use(createPinia())
app.use(router)
app.component('VueDatePicker', VueDatePicker);
// app.use(Toasted);

app.mount('#app')
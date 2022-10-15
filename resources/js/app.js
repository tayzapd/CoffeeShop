
import './bootstrap';
import { createApp } from 'vue';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify';
import router from './router';

// Using ScrollReveal's default configuration


const vuetify = createVuetify();
const app = createApp({});

import Main from './components/Main.vue';
app.component('main-block', Main);

app.use(vuetify);
app.use(router);
app.mount('#app');

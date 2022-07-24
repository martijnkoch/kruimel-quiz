import { createApp } from 'vue'
import App from './App.vue'
import router from '@/router/index'
import { createPinia } from 'pinia'

// Vue - Initiation //
const pinia = createPinia()
const app = createApp(App);
app.use(router);
app.use(pinia);

// Vue - Set root component //
app.mount('#app');

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { GlobalData } from './global';

createApp(App).use(router).use(GlobalData.Pinia).mount('#app')


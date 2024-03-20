import './bootstrap';
import { createApp } from 'vue';
import router from './routes/main';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import StyleClass from 'primevue/styleclass';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';
import Card from 'primevue/card';

import ToastService from 'primevue/toastservice';
import 'primevue/resources/themes/aura-light-green/theme.css'

const app = createApp(App);

app.use(router);
app.use(PrimeVue, { ripple: true });
app.use(ToastService);
app.directive('styleclass', StyleClass);

app.component('Button', Button);
app.component('Avatar', Avatar);
app.component('Card', Card);
app.mount('#app');

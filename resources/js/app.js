import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Editor from 'primevue/editor';
import FileUpload from 'primevue/fileupload';
import Timeline from 'primevue/timeline';
import Card from 'primevue/card';
import Avatar from 'primevue/avatar';
import Button from 'primevue/button';
import SpeedDial from 'primevue/speeddial';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import { createI18n  } from 'vue-i18n';
import ar from './locales/ar.json';
import en from './locales/en.json';
import "primeicons/primeicons.css"
import 'primevue/resources/themes/aura-light-green/theme.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const i18n = createI18n({
    locale: localStorage.getItem('locale'),
    messages: {
        en: en,
        ar: ar,
    },
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(PrimeVue, { ripple: true })
            .use(ToastService)
            .component('Editor', Editor)
            .component('FileUpload', FileUpload)
            .component('Timeline', Timeline)
            .component('Card', Card)
            .component('Avatar', Avatar)
            .component('Button', Button)
            .component('SpeedDial', SpeedDial)
            .component('Toast', Toast)
            .use(ZiggyVue)
            .mixin({
                methods: {
                    locale: () => localStorage.getItem('locale'),
                },
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

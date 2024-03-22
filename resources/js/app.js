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
import "primeicons/primeicons.css"
import 'primevue/resources/themes/aura-light-green/theme.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, { ripple: true })
            .component('Editor', Editor)
            .component('FileUpload', FileUpload)
            .component('Timeline', Timeline)
            .component('Card', Card)
            .component('Avatar', Avatar)
            .component('Button', Button)
            .component('SpeedDial', SpeedDial)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

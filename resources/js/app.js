require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import VueApexCharts from "vue3-apexcharts";
import VueNumeric from "vue-numeric";
import VueNumberInput from '@chenfengyuan/vue-number-input';



const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .use(VueApexCharts)
            .use(VueNumeric)
            .component(VueNumberInput.name, VueNumberInput)
            .mount(el);
            
    },
});

InertiaProgress.init({ color: '#4B5563' });

import "./bootstrap";
import "../css/app.scss";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { Tabs, Tab } from "vue3-tabs-component";
import PrimeVue from "primevue/config";
import "primevue/resources/themes/aura-light-green/theme.css";
import Tooltip from 'primevue/tooltip';


const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component("tabs", Tabs)
            .component("tab", Tab)
            .directive('tooltip', Tooltip)
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});

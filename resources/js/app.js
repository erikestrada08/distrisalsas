import "../css/app.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// Importar FontAwesome
import "@fortawesome/fontawesome-free/css/all.css";
import "@fortawesome/fontawesome-free/js/all.js";

// Importar Sweet Alert 2
import Swal from "sweetalert2";

// Importar store de Vuex
import store from "./store";

// Importar primevue
import PrimeVue from "primevue/config";
import Aura from "@primeuix/themes/aura";

// Importar directiva personalizada para animacion scroll
import ScrollAnimation from './Directives/ScrollAnimation'
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// Initialize theme (light/dark) before app mounts
(() => {
    try {
        const storageKey = 'theme';
        const user = localStorage.getItem(storageKey);
        const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = user || (systemPrefersDark ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', theme === 'dark');
    } catch (_) {
        // no-op
    }
})();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./${name}.vue`,
            import.meta.glob("./**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin)
            .use(ZiggyVue)
            .use(store)
            .use(PrimeVue, { theme: { preset: Aura } })
            .directive('scroll-animation', ScrollAnimation);
        app.config.globalProperties.$swal = Swal;
        return app.mount(el);
    },
    progress: { color: "#4B5563" },
});

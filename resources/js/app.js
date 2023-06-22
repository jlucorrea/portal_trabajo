import "./bootstrap";
import "../css/app.css";

import { createApp, defineAsyncComponent } from "vue";
import ElementPlus from "element-plus";
import "element-plus/dist/index.css";
import es from "element-plus/dist/locale/es.mjs";
import mitt from "mitt";

// JS
import "bootstrap/dist/js/bootstrap.js";

const emitter = mitt();
const app = createApp({});

app.provide("emitter", emitter);
app.use(ElementPlus, { size: "small", locale: es });

app.component(
    "Home",
    defineAsyncComponent(() => import("./views/Home/Home.vue"))
);

app.component(
    "Register",
    defineAsyncComponent(() => import("./views/Register/Register.vue"))
);

app.component(
    "Jobs",
    defineAsyncComponent(() => import("./views/Jobs/index.vue"))
);

app.component(
    "Postulacion",
    defineAsyncComponent(() => import("./views/Postulacion/index.vue"))
);


app.mount("#app");

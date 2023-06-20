import "./bootstrap";
import { createApp, defineAsyncComponent } from "vue";
import ElementPlus from "element-plus";
import es from "element-plus/dist/locale/es.mjs";
import mitt from "mitt";
// JS
import "bootstrap/dist/js/bootstrap.js";
// CSS
import "bootstrap/dist/css/bootstrap.css";
import "../css/app.css";

const emitter = mitt();
const app = createApp({});

app.provide("emitter", emitter);
app.use(ElementPlus, { size: "small", locale: es });

app.component(
    "Login",
    defineAsyncComponent(() => import("./views/Login/Login.vue"))
);

// app.component("Login", Login);
app.mount("#app");

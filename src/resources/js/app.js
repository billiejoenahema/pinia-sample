import "./bootstrap";
import "../css/app.css";
import "../scss/styles.scss";

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

const pinia = createPinia();

library.add(fas);

createApp(App)
  .use(router)
  .use(pinia)
  .component("font-awesome-icon", FontAwesomeIcon)
  .mount("#app");

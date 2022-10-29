import { createRouter, createWebHistory } from "vue-router";
import Top from "@/views/Top.vue";
import NotFound from "@/views/NotFound.vue";

const routes = [
  {
    path: "/",
    component: Top,
  },
  {
    path: "/:catchAll(.*)",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
});

export default router;

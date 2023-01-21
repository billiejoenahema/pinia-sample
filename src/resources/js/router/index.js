import { createRouter, createWebHistory } from "vue-router";
import Top from "@/views/Top.vue";
import UserDetail from "@/views/UserDetail.vue";
import UserEdit from "@/views/UserEdit.vue";
import NotFound from "@/views/NotFound.vue";

const routes = [
  {
    path: "/",
    component: Top,
  },
  {
    path: "/users/:id",
    name: "UserDetail",
    component: UserDetail,
  },
  {
    path: "/users/:id/edit",
    name: "UserEdit",
    component: UserEdit,
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

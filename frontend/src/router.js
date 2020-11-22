import { createWebHistory, createRouter } from "vue-router";
import Login from "@/views/Login.vue";
import Home from '@/views/Home.vue';
import List from '@/views/children/List.vue';
import Create from '@/views/children/Create.vue';
import Error from "@/views/Error.vue";



const routes = [
  {
    path: "/",
    name: "login",
    component: Login,
  },
  {
    path: "/home",
    name: "home",
    component: Home,
    meta: {
        requiresAuth: true
    },
    children: [
                {
                  path: "/home/list",
                  name: "home/list",
                  components: {
                      home_route_view: List
                  }
                },
                {
                  path: "/home/create",
                  name: "home/create",
                  components: {
                      home_route_view: Create
                  }
                }
              ]
  },
  {
      path: "/:pathMatch(.*)*",
      name: "error",
      component: Error,
      meta: {
          error: true
      }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
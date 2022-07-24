import { createWebHistory, createRouter } from "vue-router";
import Signup from "@/views/Signup.vue";
import Question from "@/views/Question.vue";
import Leaderboard from "@/views/Leaderboard.vue";

const routes = [
  {
    path: "/",
    name: "Signup",
    component: Signup,
  },
  {
    path: "/Question",
    name: "Question",
    component: Question,
  },
  {
    path: "/leaderboard",
    name: "Leaderboard",
    component: Leaderboard,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

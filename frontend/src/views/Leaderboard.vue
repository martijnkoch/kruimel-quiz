<template>
  <div class="page home background-butterflies">
    <div class="full-width">
      <div class="question-container">
        <h2>Leaderboard</h2>

        <ul>
        <h2>{{user}}</h2>
          <li v-for="(user, index) in users">

              {{ user.name + ' ' +user.score }}
         
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import axios from "axios";

export default defineComponent({
  data() {
    return {
      users: "",
    };
  },
  mounted() {
    axios
      .get("http://127.0.0.1:8000/api/leaderboard")
      .then((response) => {
        this.users = response.data;
        console.log(this.users);
      })
      .catch((error) => {
        console.log(error);
      });
  },
});
</script>

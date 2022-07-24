<template>
  <h1>Kruimelquiz</h1>
  <form>
    <label>Je naam</label>
    <input type="text" v-model="name" />
    <p>{{ errors.name }}</p>
    <button @click.prevent="submit()">Start de quiz!</button>
  </form>
</template>

<script>
import { defineComponent } from "vue";
import { useQuizStore } from "@/store/dataStore";
import axios from "axios";

export default defineComponent({
  data() {
    return {
      errors: [],
      valid: true,
      name: "",
    };
  },
  methods: {
    submit() {
      this.errors = [];
      let valid = true;

      const validatetName = (name) => {
        if (!name.length) {
          return { valid: false, error: "Voornaam is verplicht" };
        } else if (name.length > 30) {
          return { valid: false, error: "Voornaam is te lang" };
        }
        return { valid: true, error: null };
      };

      const validName = validatetName(this.name);
      this.errors.name = validName.error;
      if (valid) {
        valid = validName.valid;
      }

      if (valid) {
        const postData = {
          name: this.name,
        };

        axios
          .post("http://127.0.0.1:8000/api/player", postData)
          .then(() => {
            const store = useQuizStore();
            store.$patch({ playerName: this.name });

            this.$router.push("/question");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
});
</script>

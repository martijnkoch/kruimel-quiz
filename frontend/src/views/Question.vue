<template>
  <div class="page home background-butterflies">
    <div class="full-width">
      <div v-if="state == 'question'" class="question-container">
        <h2>"{{ question.question }}"</h2>

        <ul>
          <li v-for="(answer, index) in question.answers">
            <button
              v-on:click="handleResponse"
              v-bind:data-id="index"
              ref="submitBtn"
            >
              {{ answer.answer }}
            </button>
          </li>
        </ul>
      </div>

      <div v-if="state == 'answer'" class="question-container">
        <h2>"{{ question.question }}"</h2>
        <ul>
          <li v-for="answer in question.answers">
            <div
              v-bind:class="{
                'correct-answer': answer.id == selectedAnswer && answer.correct,
                'wrong-answer': answer.id == selectedAnswer && !answer.correct,
              }"
            >
              {{ answer.answer }}
            </div>
          </li>
        </ul>

        <button v-on:click="handleNext" class="button-next-question">
          Next question
        </button>
      </div>

      <div v-if="state == 'results'" class="result-wrapper">
        <p>Your result</p>
        <p>{{ scorePercentage }}</p>
        <p>{{ score }} out of {{ questions.length }} good</p>
        <p>lol</p>
        <router-link to="/leaderboard">Ga naar leaderboard</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import { useQuizStore } from "@/store/dataStore";
import axios from "axios";

export default defineComponent({
  data() {
    return {
      state: "question",
      currentQuestion: 0,
      selectedAnswer: 0,
      questions: [
        {
          question: "Je maakt me wel ... maar je laat me niet komen.",
          author: "Ying",
          answers: [
            {
              answer: "geil",
              id: 0,
              correct: true,
            },
            {
              answer: "horny",
              id: 0,
            },
            {
              answer: "nat",
              id: 0,
            },
            {
              answer: "heet",
              id: 0,
            },
          ],
        },
        {
          question: "Ik voelde me gister niet zo lekker dus toen nam ik ...",
          author: "Ying",
          answers: [
            {
              answer: "kfc",
              id: 0,
            },
            {
              answer: "maccie",
              id: 0,
              correct: true,
            },
            {
              answer: "taco bell",
              id: 0,
            },
            {
              answer: "hizzie",
              id: 0,
            },
          ],
        },
        {
          question: "Wodihh ... dat is kaolo ver",
          author: "Ying",
          answers: [
            {
              answer: "mattie",
              id: 0,
              correct: true,
            },
            {
              answer: "nerdje",
              id: 0,
            },
            {
              answer: "dipshit",
              id: 0,
            },
            {
              answer: "nerdje",
              id: 0,
            },
          ],
        },
        {
          question: "Paneer me ...",
          author: "Marijn",
          answers: [
            {
              answer: "hoertje",
              id: 0,
            },
            {
              answer: "schatje",
              id: 0,
              correct: true,
            },
            {
              answer: "liefje",
              id: 0,
            },
            {
              answer: "kara",
              id: 0,
            },
          ],
        },
        {
          question: "... beste bouwjaar",
          author: "Martijn",
          answers: [
            {
              answer: "94",
              id: 0,
            },
            {
              answer: "93",
              id: 0,
            },
            {
              answer: "92",
              id: 0,
              correct: true,
            },
            {
              answer: "91",
              id: 0,
            },
          ],
        },
        {
          question: "Hoe dieper de ... hoe beter de sniff",
          author: "Ying",
          answers: [
            {
              answer: "neus",
              id: 0,
              correct: true,
            },
            {
              answer: "vuist",
              id: 0,
            },
            {
              answer: "mond",
              id: 0,
            },
            {
              answer: "loempia",
              id: 0,
            },
          ],
        },
      ],
      score: 0,
    };
  },
  computed: {
    question() {
      return this.questions[this.currentQuestion];
    },
    scorePercentage() {
      return this.score * 100;
    },
  },
  created() {
    this.randomizeOrder();
  },
  methods: {
    handleResponse(event) {
      const selected = this.question.answers.find(
        (a, index) => index == event.target.dataset.id
      );

      if (!selected) return;

      this.selectedAnswer = selected.id;
      if (selected.correct) {
        this.score++;
      }

      this.state = "answer";
      setTimeout(() => {
        this.handleNext();
      }, 1000);
    },
    handleNext() {
      this.currentQuestion++;
      if (this.currentQuestion >= this.questions.length) {
        this.state = "results";

        const store = useQuizStore();
        const postData = {
            name: store.playerName,
            score: this.score * 100
        };

        axios
          .post("http://127.0.0.1:8000/api/score", postData)
          .catch((error) => {
            console.log(error);
          });

      } else {
        this.state = "question";
      }
    },
    randomizeOrder() {
      this.questions.map((question) => {
        question.answers.sort((a, b) => Math.random() - 0.5);
        question.answers.map((answer, index) => (answer.id = index));
      });
      this.questions.sort((a, b) => Math.random() - 0.5);
    },
    handleRestart() {
      this.currentQuestion = 0;
      this.score = 0;
      this.state = "question";
      this.randomizeOrder();
    },
  },
});
</script>

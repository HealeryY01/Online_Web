<template>
  <div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-4 no-select">Kết quả bài thi</h1>

      <div class="bg-green-100 p-4 rounded-lg mb-4">
        <h2 class="text-xl font-semibold text-green-800 no-select">
          Điểm số: {{ result.score }}/{{ result.totalScore }}
        </h2>
        <p class="text-gray-600 no-select">
          Số câu đúng: {{ result.correctAnswers }} / {{ result.totalQuestions }}
        </p>
      </div>

      <div class="space-y-4">
        <div
          v-for="question in result.questions"
          :key="question.id"
          class="p-4 border rounded-lg"
        >
          <h3 class="text-lg font-semibold">{{ question.question_text }}</h3>
          <ul class="mt-2 space-y-1">
            <li
              v-for="answer in question.answers"
              :key="answer.id"
              class="p-2 rounded"
              :class="{
                'bg-red-300': question.selectedAnswer === answer.id && !answer.is_correct,
                'bg-green-300': answer.is_correct,
                'bg-gray-100':
                  question.selectedAnswer !== answer.id && !answer.is_correct,
              }"
            >
              {{ answer.answer_text }}
              <span v-if="answer.is_correct" class="text-green-800 font-semibold">
                (Đáp án đúng)
              </span>
              <span
                v-if="question.selectedAnswer === answer.id && !answer.is_correct"
                class="text-red-800 font-semibold"
              >
                (Bạn chọn sai)
              </span>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-6 text-center">
        <router-link
          to="/"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
        >
          Quay về trang chủ
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      result: {
        score: 0,
        totalScore: 0,
        correctAnswers: 0,
        totalQuestions: 0,
        questions: [],
      },
    };
  },
  async created() {
    const attemptId = this.$route.params.attemptId;
    try {
      const response = await axios.get(`/api/exam-attempts/${attemptId}/result`);
      this.result = response.data;
    } catch (error) {
      console.error("Lỗi khi tải kết quả bài thi:", error);
    }
  },
};
</script>

<style>
.no-select {
  user-select: none;
}
</style>

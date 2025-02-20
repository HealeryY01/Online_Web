<template>
  <div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-4 no-select">Bài Thi: {{ exam.title }}</h1>

      <!-- Thanh tiến trình -->
      <div class="relative pt-1 mb-4">
        <div class="flex mb-2 items-center justify-between">
          <span
            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 no-select"
          >
            Câu hỏi {{ currentIndex + 1 }} / {{ questions.length }}
          </span>
        </div>
        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
          <div
            :style="{ width: progress + '%' }"
            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"
          ></div>
        </div>
      </div>

      <!-- Hiển thị câu hỏi -->
      <div v-if="currentQuestion">
        <h2 class="text-lg font-semibold">{{ currentQuestion.question_text }}</h2>
        <div class="mt-4 space-y-2">
          <button
            v-for="answer in currentQuestion.answers"
            :key="answer.id"
            @click="selectAnswer(answer.id)"
            class="w-full p-3 text-left border rounded-lg hover:bg-blue-100"
            :class="{ 'bg-blue-300': selectedAnswers[currentQuestion.id] === answer.id }"
          >
            {{ answer.answer_text }}
          </button>
        </div>
      </div>

      <!-- Nút điều hướng -->
      <div class="mt-6 flex justify-between">
        <button
          @click="prevQuestion"
          :disabled="currentIndex === 0"
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg"
        >
          Quay lại
        </button>
        <button
          v-if="currentIndex < questions.length - 1"
          @click="nextQuestion"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg"
        >
          Tiếp tục
        </button>
        <button
          v-else
          @click="submitExam"
          class="px-4 py-2 bg-green-600 text-white rounded-lg"
        >
          Nộp bài
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      exam: {},
      questions: [],
      currentIndex: 0,
      selectedAnswers: {},
    };
  },
  computed: {
    currentQuestion() {
      return this.questions[this.currentIndex] || null;
    },
    progress() {
      return ((this.currentIndex + 1) / this.questions.length) * 100;
    },
  },
  methods: {
    async fetchExamData() {
      const examId = this.$route.params.examId;
      try {
        const [examResponse, questionsResponse] = await Promise.all([
          axios.get(`/api/exams/${examId}`),
          axios.get(`/api/exams/${examId}/questions`),
        ]);

        this.exam = examResponse.data;
        this.questions = questionsResponse.data;
      } catch (error) {
        console.error("Lỗi khi tải dữ liệu bài thi:", error);
      }
    },
    selectAnswer(answerId) {
      this.selectedAnswers[this.currentQuestion.id] = answerId;
    },
    prevQuestion() {
      if (this.currentIndex > 0) {
        this.currentIndex--;
      }
    },
    nextQuestion() {
      if (this.currentIndex < this.questions.length - 1) {
        this.currentIndex++;
      }
    },
    async submitExam() {
      try {
        const response = await axios.post(`/api/exam-attempts/submit`, {
          exam_id: this.exam.id,
          answers: this.selectedAnswers,
        });

        if (response.data.success) {
          this.$router.push(`/exam/${this.exam.id}/result`);
        }
      } catch (error) {
        console.error("Lỗi khi nộp bài thi:", error);
      }
    },
  },
  created() {
    this.fetchExamData();
  },
};
</script>

<style>
.no-select {
  user-select: none;
}
</style>

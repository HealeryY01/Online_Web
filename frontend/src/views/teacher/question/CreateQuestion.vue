<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Thêm câu hỏi mới</h1>
    <form @submit.prevent="handleCreateQuestion">
      <div class="mb-4">
        <label
          for="questionText"
          class="block text-sm font-medium text-gray-700"
          >Câu hỏi</label
        >
        <input
          type="text"
          v-model="questionText"
          id="questionText"
          class="input-field"
          required
        />
      </div>
      <div class="mb-4">
        <label
          for="correctAnswer"
          class="block text-sm font-medium text-gray-700"
          >Câu trả lời đúng</label
        >
        <input
          type="text"
          v-model="correctAnswer"
          id="correctAnswer"
          class="input-field"
          required
        />
      </div>
      <div class="mb-4">
        <label
          for="wrongAnswers"
          class="block text-sm font-medium text-gray-700"
          >Câu trả lời sai (cách nhau bằng dấu phẩy)</label
        >
        <input
          type="text"
          v-model="wrongAnswers"
          id="wrongAnswers"
          class="input-field"
          placeholder="Câu trả lời sai 1, Câu trả lời sai 2"
          required
        />
      </div>
      <div class="flex justify-end">
        <button type="submit" class="btn-primary">Tạo câu hỏi</button>
      </div>
    </form>
  </div>
</template>

<script>
import axiosInstance from "@/plugins/axios";

export default {
  data() {
    return {
      questionText: "",
      correctAnswer: "",
      wrongAnswers: "",
    };
  },
  methods: {
    async handleCreateQuestion() {
      const answers = this.wrongAnswers
        .split(",")
        .map((answer) => answer.trim());
      const questionData = {
        text: this.questionText,
        correctAnswer: this.correctAnswer,
        wrongAnswers: answers,
      };

      try {
        // Gọi API để lưu câu hỏi
        const response = await axiosInstance.post(
          "/teacher/question",
          questionData
        );
        console.log("Câu hỏi đã được tạo:", response.data);
        // Reset form
        this.questionText = "";
        this.correctAnswer = "";
        this.wrongAnswers = "";
        // Chuyển hướng về trang ngân hàng câu hỏi
        this.$router.push("/teacher/question-bank");
      } catch (error) {
        console.error("Lỗi khi tạo câu hỏi:", error);
      }
    },
  },
};
</script>

<style scoped>
.input-field {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}
.btn-primary {
  background-color: #4caf50;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Ngân hàng câu hỏi</h1>

    <!-- Thêm câu hỏi -->
    <form @submit.prevent="handleAddQuestion" class="mb-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input
          v-model="newQuestion.text"
          type="text"
          placeholder="Nhập câu hỏi"
          class="input-field"
          required
        />
        <input
          v-model="newQuestion.answer"
          type="text"
          placeholder="Nhập câu trả lời đúng"
          class="input-field"
          required
        />
      </div>
      <div class="flex justify-end mt-4">
        <button type="submit" class="btn-primary">Thêm câu hỏi</button>
      </div>
    </form>

    <!-- Danh sách câu hỏi -->
    <div v-if="questions.length > 0">
      <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="border border-gray-300 p-2">#</th>
            <th class="border border-gray-300 p-2">Câu hỏi</th>
            <th class="border border-gray-300 p-2">Câu trả lời</th>
            <th class="border border-gray-300 p-2">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(question, index) in questions" :key="question.id">
            <td class="border border-gray-300 p-2 text-center">
              {{ index + 1 }}
            </td>
            <td class="border border-gray-300 p-2">{{ question.text }}</td>
            <td class="border border-gray-300 p-2">{{ question.answer }}</td>
            <td class="border border-gray-300 p-2 text-center">
              <button
                @click="editQuestion(question)"
                class="btn-secondary mr-2"
              >
                Chỉnh sửa
              </button>
              <button @click="deleteQuestion(question.id)" class="btn-danger">
                Xóa
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>Không có câu hỏi nào. Thêm câu hỏi mới để bắt đầu.</p>
    </div>

    <!-- Modal chỉnh sửa câu hỏi -->
    <div v-if="isEditing" class="modal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">Chỉnh sửa câu hỏi</h2>
        <form @submit.prevent="handleEditQuestion">
          <input
            v-model="editQuestionData.text"
            type="text"
            class="input-field mb-4"
            required
          />
          <input
            v-model="editQuestionData.answer"
            type="text"
            class="input-field mb-4"
            required
          />
          <div class="flex justify-end">
            <button
              type="button"
              @click="isEditing = false"
              class="btn-secondary mr-2"
            >
              Hủy
            </button>
            <button type="submit" class="btn-primary">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from "@/plugins/axios";

export default {
  data() {
    return {
      questions: [],
      newQuestion: { text: "", answer: "" },
      isEditing: false,
      editQuestionData: { id: null, text: "", answer: "" },
    };
  },
  methods: {
    async fetchQuestions() {
      try {
        const response = await axiosInstance.get("/admin/questions");
        this.questions = response.data;
      } catch (error) {
        console.error("Lỗi khi lấy danh sách câu hỏi:", error);
      }
    },
    async handleAddQuestion() {
      try {
        const response = await axiosInstance.post(
          "/admin/questions",
          this.newQuestion
        );
        this.questions.push(response.data);
        this.newQuestion = { text: "", answer: "" };
      } catch (error) {
        console.error("Lỗi khi thêm câu hỏi:", error);
      }
    },
    editQuestion(question) {
      this.isEditing = true;
      this.editQuestionData = { ...question };
    },
    async handleEditQuestion() {
      try {
        const response = await axiosInstance.put(
          `/admin/questions/${this.editQuestionData.id}`,
          this.editQuestionData
        );
        const index = this.questions.findIndex(
          (q) => q.id === this.editQuestionData.id
        );
        if (index !== -1) {
          this.questions[index] = response.data;
        }
        this.isEditing = false;
      } catch (error) {
        console.error("Lỗi khi chỉnh sửa câu hỏi:", error);
      }
    },
    async deleteQuestion(id) {
      try {
        await axiosInstance.delete(`/admin/questions/${id}`);
        this.questions = this.questions.filter(
          (question) => question.id !== id
        );
      } catch (error) {
        console.error("Lỗi khi xóa câu hỏi:", error);
      }
    },
  },
  mounted() {
    this.fetchQuestions();
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
.btn-secondary {
  background-color: #007bff;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-danger {
  background-color: #e74c3c;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
}
</style>

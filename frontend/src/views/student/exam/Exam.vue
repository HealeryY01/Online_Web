<template>
  <div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4 no-select">Danh sách kỳ thi</h1>

    <!-- Form Thêm Kỳ Thi -->
    <div class="bg-gray-100 p-4 rounded-lg mb-4">
      <h2 class="text-lg font-semibold">Thêm kỳ thi</h2>
      <input
        v-model="newExam.name"
        type="text"
        placeholder="Tên kỳ thi"
        class="border p-2 w-full mb-2 rounded"
      />
      <input
        v-model="newExam.start_date"
        type="datetime-local"
        class="border p-2 w-full mb-2 rounded"
      />
      <input
        v-model="newExam.end_date"
        type="datetime-local"
        class="border p-2 w-full mb-2 rounded"
      />
      <button
        @click="addExam"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Thêm
      </button>
    </div>

    <!-- Danh sách kỳ thi -->
    <div v-if="exams.length">
      <div
        v-for="exam in exams"
        :key="exam.id"
        class="bg-white p-4 rounded-lg shadow mb-3"
      >
        <h2 class="text-lg font-semibold">{{ exam.name }}</h2>
        <p class="text-gray-600">Bắt đầu: {{ formatDate(exam.start_date) }}</p>
        <p class="text-gray-600">Kết thúc: {{ formatDate(exam.end_date) }}</p>
        <router-link :to="`/exam/${exam.id}`" class="text-blue-500 hover:underline">
          Bắt đầu thi
        </router-link>
      </div>
    </div>
    <p v-else class="text-gray-600 no-select">Không có kỳ thi nào.</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      exams: [],
      newExam: {
        name: "",
        start_date: "",
        end_date: "",
      },
    };
  },
  async created() {
    await this.fetchExams();
  },
  methods: {
    async fetchExams() {
      try {
        const response = await axios.get("http://localhost/api/exams");
        this.exams = response.data;
      } catch (error) {
        console.error("Lỗi khi tải danh sách kỳ thi:", error);
      }
    },
    async addExam() {
      try {
        const response = await axios.post(
          "http://localhost/api/exams/get_exams.php",
          this.newExam
        );
        this.exams.push(response.data);
        this.newExam = { name: "", start_date: "", end_date: "" };
      } catch (error) {
        console.error("Lỗi khi thêm kỳ thi:", error);
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleString("vi-VN");
    },
  },
};
</script>

<style>
.no-select {
  user-select: none;
}
</style>

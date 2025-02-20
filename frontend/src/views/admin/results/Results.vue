<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Kết quả thi</h1>
    <div v-if="results.length > 0">
      <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="border border-gray-300 p-2">#</th>
            <th class="border border-gray-300 p-2">Tên học sinh</th>
            <th class="border border-gray-300 p-2">Điểm</th>
            <th class="border border-gray-300 p-2">Thời gian làm bài</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(result, index) in results" :key="result.id">
            <td class="border border-gray-300 p-2 text-center">
              {{ index + 1 }}
            </td>
            <td class="border border-gray-300 p-2">{{ result.studentName }}</td>
            <td class="border border-gray-300 p-2">{{ result.score }}</td>
            <td class="border border-gray-300 p-2">{{ result.timeTaken }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>Không có kết quả nào để hiển thị.</p>
    </div>
  </div>
</template>

<script>
import axiosInstance from "@/plugins/axios";

export default {
  data() {
    return {
      results: [],
    };
  },
  methods: {
    async fetchResults() {
      try {
        const response = await axiosInstance.get("/admin/results");
        this.results = response.data;
      } catch (error) {
        console.error("Lỗi khi lấy kết quả thi:", error);
      }
    },
  },
  mounted() {
    this.fetchResults();
  },
};
</script>

<style scoped>
/* Thêm các kiểu CSS nếu cần */
</style>

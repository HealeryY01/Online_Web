<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Lịch sử hệ thống</h1>
    <div v-if="logs.length > 0">
      <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="border border-gray-300 p-2">#</th>
            <th class="border border-gray-300 p-2">Thời gian</th>
            <th class="border border-gray-300 p-2">Nội dung</th>
            <th class="border border-gray-300 p-2">Người thực hiện</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(log, index) in logs" :key="log.id">
            <td class="border border-gray-300 p-2 text-center">
              {{ index + 1 }}
            </td>
            <td class="border border-gray-300 p-2">{{ log.timestamp }}</td>
            <td class="border border-gray-300 p-2">{{ log.content }}</td>
            <td class="border border-gray-300 p-2">{{ log.user }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>Không có lịch sử nào để hiển thị.</p>
    </div>
  </div>
</template>

<script>
import axiosInstance from "@/plugins/axios";

export default {
  data() {
    return {
      logs: [],
    };
  },
  methods: {
    async fetchLogs() {
      try {
        const response = await axiosInstance.get("/admin/system-logs");
        this.logs = response.data;
      } catch (error) {
        console.error("Lỗi khi lấy lịch sử hệ thống:", error);
      }
    },
  },
  mounted() {
    this.fetchLogs();
  },
};
</script>

<style scoped>
/* Thêm các kiểu CSS nếu cần */
</style>

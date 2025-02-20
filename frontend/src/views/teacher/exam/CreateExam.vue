<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Tạo kỳ thi mới</h1>
    <form @submit.prevent="handleCreateExam">
      <div class="mb-4">
        <label for="examName" class="block text-sm font-medium text-gray-700"
          >Tên kỳ thi</label
        >
        <input
          type="text"
          v-model="examName"
          id="examName"
          class="input-field"
          required
        />
      </div>
      <div class="mb-4">
        <label for="examDate" class="block text-sm font-medium text-gray-700"
          >Ngày thi</label
        >
        <input
          type="date"
          v-model="examDate"
          id="examDate"
          class="input-field"
          required
        />
      </div>
      <div class="flex justify-end">
        <button type="submit" class="btn-primary">Tạo kỳ thi</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      examName: "",
      examDate: "",
    };
  },
  methods: {
    async handleCreateExam() {
      // Logic để tạo kỳ thi mới
      console.log("Tạo kỳ thi:", this.examName, "vào ngày:", this.examDate);
      // Gọi API để lưu kỳ thi
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

<template>
  <div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold mb-6">Danh sách kỳ thi</h1>
      <div class="bg-white p-6 rounded-lg shadow">
        <button
          @click="fetchExams"
          class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
        >
          Tải danh sách kỳ thi
        </button>
        <table class="min-w-full bg-white border border-gray-300 mt-4">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b">Tên kỳ thi</th>
              <th class="py-2 px-4 border-b">Ngày bắt đầu</th>
              <th class="py-2 px-4 border-b">Ngày kết thúc</th>
              <th class="py-2 px-4 border-b">Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="exam in exams" :key="exam.id">
              <td class="py-2 px-4 border-b">{{ exam.name }}</td>
              <td class="py-2 px-4 border-b">{{ exam.start_date }}</td>
              <td class="py-2 px-4 border-b">{{ exam.end_date }}</td>
              <td class="py-2 px-4 border-b">
                <button
                  @click="editExam(exam.id)"
                  class="bg-yellow-500 text-white rounded px-2 py-1 hover:bg-yellow-600"
                >
                  Chỉnh sửa
                </button>
                <button
                  @click="deleteExam(exam.id)"
                  class="bg-red-500 text-white rounded px-2 py-1 hover:bg-red-600 ml-2"
                >
                  Xóa
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
  name: "ExamManagement",
  computed: {
    ...mapState(["exams"]),
  },
  methods: {
    ...mapActions(["fetchExams", "editExam", "deleteExam"]),
  },
  created() {
    this.$store.dispatch("fetchExams");
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

th {
  background-color: #f9fafb;
}

td {
  text-align: left;
}
</style>

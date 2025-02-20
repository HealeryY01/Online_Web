<template>
  <div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold mb-6 text-center">Phân quyền người dùng</h1>
      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
          <tr class="bg-gray-200">
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">
            <td>{{ user.full_name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.role }}</td>
            <td>
              <div class="flex justify-center space-x-2">
                <button
                  @click="changeRole(user.id, 'admin')"
                  class="bg-blue-500 text-white rounded px-2 py-1 hover:bg-blue-600 transition"
                >
                  Admin
                </button>
                <button
                  @click="changeRole(user.id, 'student')"
                  class="bg-green-500 text-white rounded px-2 py-1 hover:bg-green-600 transition"
                >
                  Student
                </button>
                <button
                  @click="changeRole(user.id, 'teacher')"
                  class="bg-gray-500 text-white rounded px-2 py-1 hover:bg-gray-600 transition"
                >
                  Teacher
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import axios from "axios";

export default {
  name: "UserAuthorization",
  computed: {
    ...mapState(["users"]),
  },
  methods: {
    ...mapActions(["changeUserRole"]),
    async fetchUsers() {
      try {
        const response = await axios.get(
          "http://localhost/online-exam-website/backend/api/users/get_users.php"
        );
        if (response.data.success) {
          this.users = response.data.users; // Cập nhật danh sách người dùng
        } else {
          alert(response.data.message);
        }
      } catch (error) {
        console.error("Lỗi khi tải danh sách người dùng:", error);
        alert("Có lỗi xảy ra khi tải danh sách người dùng.");
      }
    },
    async changeRole(userId, newRole) {
      try {
        const response = await axios.post(
          "http://localhost/online-exam-website/backend/api/roles/update_user_role.php",
          {
            userId,
            newRole,
          }
        );
        if (response.data.success) {
          this.changeUserRole({ userId, newRole });
          alert("Đã thay đổi vai trò của ${userId} thành ${newRole}");
        } else {
          alert(response.data.message);
        }
      } catch (error) {
        console.error("Lỗi khi thay đổi vai trò:", error);
        alert("Có lỗi xảy ra khi thay đổi vai trò người dùng.");
      }
    },
  },
  mounted() {
    this.$store.dispatch("fetchUsers"); // Gọi action để tải danh sách người dùng
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  text-align: center;
  padding: 10px;
}

th {
  background-color: #f9fafb;
}

td {
  border-bottom: 1px solid #e0e0e0;
}

button {
  margin: 0 5px;
}
</style>

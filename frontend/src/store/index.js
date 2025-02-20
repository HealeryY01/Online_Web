import { createStore } from "vuex";
import axios from "axios";

// Tạo Vuex store
const store = createStore({
  state: {
    users: [], // Danh sách người dùng
    exams: [], // Danh sách kỳ thi
  },
  mutations: {
    // Cập nhật danh sách người dùng
    setUsers(state, users) {
      state.users = users;
    },
    // Thay đổi vai trò của người dùng
    changeUserRole(state, { userId, newRole }) {
      const user = state.users.find((u) => u.id === userId);
      if (user) {
        user.role = newRole;
        console.log(
          `Cập nhật vai trò của người dùng ${userId} thành ${newRole}`
        );
      } else {
        console.error(`Không tìm thấy người dùng với ID ${userId}`);
      }
    },
    // Cập nhật danh sách kỳ thi
    setExams(state, exams) {
      state.exams = exams;
    },
  },
  actions: {
    // Gọi API để lấy danh sách người dùng
    async fetchUsers({ commit }) {
      try {
        const response = await axios.get(
          "http://localhost/online-exam-website/backend/api/users/get_users.php"
        );
        if (response.data.success) {
          commit("setUsers", response.data.users); // Cập nhật danh sách người dùng
        } else {
          console.error("Lỗi từ server:", response.data.message);
        }
      } catch (error) {
        console.error("Lỗi khi gọi API fetchUsers:", error);
      }
    },

    // Thay đổi vai trò của người dùng
    async changeUserRole({ commit }, { userId, newRole }) {
      try {
        const response = await axios.post(
          "http://localhost/online-exam-website/backend/api/roles/update_user_role.php",
          { userId, newRole }
        );

        if (response.data.success) {
          commit("changeUserRole", { userId, newRole });
          alert(`Cập nhật vai trò thành công: ${newRole}`);
        } else {
          alert(response.data.message);
        }
      } catch (error) {
        console.error("Lỗi khi cập nhật vai trò:", error);
        alert("Có lỗi xảy ra khi cập nhật vai trò.");
      }
    },

    // Gọi API để lấy danh sách kỳ thi
    async fetchExams({ commit }) {
      try {
        const response = await axios.get(
          "http://localhost/online-exam-website/backend/api/exams/get_exams.php"
        );
        if (response.data.success) {
          commit("setExams", response.data.exams);
        } else {
          console.error("Lỗi từ server:", response.data.message);
        }
      } catch (error) {
        console.error("Lỗi khi gọi API fetchExams:", error);
      }
    },
  },
});

export default store; // Xuất store để sử dụng trong ứng dụng Vue 3

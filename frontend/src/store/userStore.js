// import { defineStore } from "pinia";
// import axios from "axios";

// export const useUserStore = defineStore("userStore", {
//   state: () => ({
//     users: [],
//     searchQuery: "",
//     roleFilter: "",
//     statusFilter: "",
//   }),
//   getters: {
//     filteredUsers(state) {
//       return state.users.filter((user) => {
//         if (!user) return false;
//         const matchesSearch =
//           user.full_name
//             ?.toLowerCase()
//             .includes(state.searchQuery.toLowerCase()) ||
//           user.email?.toLowerCase().includes(state.searchQuery.toLowerCase());
//         const matchesRole = !state.roleFilter || user.role === state.roleFilter;
//         const matchesStatus =
//           !state.statusFilter || user.status === state.statusFilter;
//         return matchesSearch && matchesRole && matchesStatus;
//       });
//     },
//   },
//   actions: {
//     async fetchUsers() {
//       try {
//         const response = await axios.get(
//           "http://localhost/online-exam-website/backend/api/users/get_users.php"
//         );
//         if (response.data.success) {
//           this.users = response.data.users;
//         } else {
//           throw new Error(response.data.message || "Không thể tải danh sách");
//         }
//       } catch (error) {
//         console.error("Lỗi khi tải danh sách người dùng:", error);
//       }
//     },
//     async changeUserRole(userId, newRole) {
//       try {
//         const response = await axios.post(
//           "http://localhost/online-exam-website/backend/api/roles/update_user_role.php",
//           { userId, newRole }
//         );
//         if (response.data.success) {
//           const user = this.users.find((user) => user.id === userId);
//           if (user) user.role = newRole;
//           alert(`Đã thay đổi vai trò của ${user.full_name} thành ${newRole}`);
//         } else {
//           alert(response.data.message);
//         }
//       } catch (error) {
//         console.error("Lỗi khi thay đổi vai trò:", error);
//         alert("Có lỗi xảy ra khi thay đổi vai trò người dùng.");
//       }
//     },
//     async saveUser(userForm, isEditing) {
//       try {
//         const url = isEditing
//           ? "http://localhost/online-exam-website/backend/api/users/update_user.php"
//           : "http://localhost/online-exam-website/backend/api/users/create_user.php";

//         const response = await axios.post(url, userForm);

//         if (response.data.success) {
//           alert(
//             isEditing ? "Cập nhật thành công!" : "Thêm người dùng thành công!"
//           );
//           this.fetchUsers();
//           return true;
//         } else {
//           alert(response.data.message);
//           return false;
//         }
//       } catch (error) {
//         console.error("Lỗi khi lưu người dùng:", error);
//         alert("Có lỗi xảy ra khi lưu thông tin");
//         return false;
//       }
//     },
//     async deleteUser(userId) {
//       try {
//         const response = await axios.post(
//           "http://localhost/online-exam-website/backend/api/users/delete_user.php",
//           { id: userId }
//         );

//         if (response.data.success) {
//           alert("Xóa người dùng thành công!");
//           this.fetchUsers();
//         } else {
//           alert(response.data.message);
//         }
//       } catch (error) {
//         console.error("Lỗi khi xóa người dùng:", error);
//         alert("Có lỗi xảy ra khi xóa người dùng");
//       }
//     },
//   },
// });

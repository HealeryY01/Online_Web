<template>
  <div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Quản lý thông báo</h1>
        <button
          @click="showAddNotificationModal = true"
          class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors"
        >
          <i class="fas fa-plus mr-2"></i>Thêm thông báo
        </button>
      </div>

      <!-- Danh sách thông báo -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  #
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Nội dung
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Thao tác
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="(notification, index) in notifications"
                :key="notification.id"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ index + 1 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ notification.content }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <button
                    @click="editNotification(notification)"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Chỉnh sửa
                  </button>
                  <button
                    @click="deleteNotification(notification.id)"
                    class="text-red-600 hover:text-red-900 ml-2"
                  >
                    Xóa
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal thêm thông báo -->
      <div v-if="showAddNotificationModal" class="modal">
        <div class="modal-content">
          <h2 class="text-xl font-bold mb-4">Thêm thông báo</h2>
          <form @submit.prevent="handleAddNotification">
            <textarea
              v-model="newNotification.content"
              class="input-field mb-4"
              placeholder="Nhập nội dung thông báo"
              required
            ></textarea>
            <div class="flex justify-end">
              <button
                type="button"
                @click="showAddNotificationModal = false"
                class="btn-secondary mr-2"
              >
                Hủy
              </button>
              <button type="submit" class="btn-primary">Lưu</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Modal chỉnh sửa thông báo -->
      <div v-if="isEditing" class="modal">
        <div class="modal-content">
          <h2 class="text-xl font-bold mb-4">Chỉnh sửa thông báo</h2>
          <form @submit.prevent="handleEditNotification">
            <textarea
              v-model="editNotificationData.content"
              class="input-field mb-4"
              required
            ></textarea>
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
  </div>
</template>

<script>
import axiosInstance from "@/plugins/axios";

export default {
  data() {
    return {
      notifications: [],
      newNotification: { content: "" },
      showAddNotificationModal: false,
      isEditing: false,
      editNotificationData: { id: null, content: "" },
    };
  },
  methods: {
    async fetchNotifications() {
      try {
        const response = await axiosInstance.get("/admin/notifications");
        this.notifications = response.data;
      } catch (error) {
        console.error("Lỗi khi lấy danh sách thông báo:", error);
      }
    },
    async handleAddNotification() {
      try {
        const response = await axiosInstance.post(
          "/admin/notifications",
          this.newNotification
        );
        this.notifications.push(response.data);
        this.newNotification.content = "";
        this.showAddNotificationModal = false;
      } catch (error) {
        console.error("Lỗi khi thêm thông báo:", error);
      }
    },
    editNotification(notification) {
      this.isEditing = true;
      this.editNotificationData = { ...notification };
    },
    async handleEditNotification() {
      try {
        const response = await axiosInstance.put(
          `/admin/notifications/${this.editNotificationData.id}`,
          this.editNotificationData
        );
        const index = this.notifications.findIndex(
          (n) => n.id === this.editNotificationData.id
        );
        if (index !== -1) {
          this.notifications[index] = response.data;
        }
        this.isEditing = false;
      } catch (error) {
        console.error("Lỗi khi chỉnh sửa thông báo:", error);
      }
    },
    async deleteNotification(id) {
      try {
        await axiosInstance.delete(`/admin/notifications/${id}`);
        this.notifications = this.notifications.filter(
          (notification) => notification.id !== id
        );
      } catch (error) {
        console.error("Lỗi khi xóa thông báo:", error);
      }
    },
  },
  mounted() {
    this.fetchNotifications();
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

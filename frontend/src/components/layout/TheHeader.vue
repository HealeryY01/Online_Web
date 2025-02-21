<template>
  <header class="bg-white shadow-md">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <div class="flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
          <router-link to="/" class="flex items-center space-x-3">
            <img
              src="@assets/images/favicon/android-chrome.png"
              alt="Logo"
              class="h-10 w-auto"
            />
            <span class="text-2xl font-bold text-gray-900">OnlineTest</span>
          </router-link>
        </div>

        <!-- Menu chính -->
        <div class="hidden lg:flex items-center space-x-8">
          <!-- Menu cho người dùng chưa đăng nhập -->
          <template v-if="!isLoggedIn">
            <router-link to="/" class="nav-link">
              <i class="fas fa-home mr-2"></i>Trang chủ
            </router-link>
            <router-link to="/about" class="nav-link">
              <i class="fas fa-info-circle mr-2"></i>Giới thiệu
            </router-link>
            <router-link to="/contact" class="nav-link">
              <i class="fas fa-envelope mr-2"></i>Liên hệ
            </router-link>
          </template>

          <!-- Menu cho người dùng đã đăng nhập -->
          <template v-if="isLoggedIn">
            <!-- Menu cho Admin -->
            <template v-if="userRole === 'admin'">
              <router-link to="/admin" class="nav-link">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
              </router-link>
              <router-link to="/admin/users" class="nav-link">
                <i class="fas fa-users mr-2"></i>Quản lý người dùng
              </router-link>
              <router-link to="/admin/exams" class="nav-link">
                <i class="fas fa-book mr-2"></i>Quản lý kỳ thi
              </router-link>
              <router-link to="/admin/notifications" class="nav-link">
                <i class="fas fa-bell mr-2"></i>Thông báo
              </router-link>
            </template>

            <!-- Menu cho Teacher -->
            <template v-if="userRole === 'teacher'">
              <router-link to="/teacher" class="nav-link">
                <i class="fas fa-book mr-2"></i>Quản lý kì thi
              </router-link>
              <router-link to="/teacher/question-bank" class="nav-link">
                <i class="fas fa-database mr-2"></i>Ngân hàng câu hỏi
              </router-link>
              <router-link to="/teacher/results" class="nav-link">
                <i class="fas fa-chart-bar mr-2"></i>Kết quả thi
              </router-link>
            </template>

            <!-- Menu cho Student -->
            <template v-if="userRole === 'student'">
              <router-link to="/student" class="nav-link">
                <i class="fas fa-edit mr-2"></i>Bảng điều khiển
              </router-link>
              <router-link to="/exam" class="nav-link">
                <i class="fas fa-edit mr-2"></i>Danh sách kì thi
              </router-link>
              <router-link to="/exampage" class="nav-link">
                <i class="fas fa-certificate mr-2"></i>Làm bài thi
              </router-link>
              <router-link to="/my-results" class="nav-link">
                <i class="fas fa-chart-line mr-2"></i>Kết quả của tôi
              </router-link>
            </template>
          </template>
        </div>

        <!-- Đăng nhập/Đăng xuất -->
        <div class="flex items-center space-x-4">
          <template v-if="!isLoggedIn">
            <router-link to="/auth" class="auth-button login">
              <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập
            </router-link>
          </template>
          <template v-else>
            <div class="flex items-center space-x-4">
              <span class="text-gray-600">
                <i class="fas fa-user mr-2"></i>{{ userfull_name }}
              </span>
              <button @click="logout" class="auth-button logout">
                <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
              </button>
            </div>
          </template>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  data() {
    return {
      userRole: "",
      menuVisible: false,
      isDesktop: window.innerWidth >= 1024,
      userEmail: "",
    };
  },
  computed: {
    isLoggedIn() {
      const user = JSON.parse(localStorage.getItem("user") || "{}");
      return user.role && localStorage.getItem("isLoggedIn") === "true";
      return true;
    },
    userfull_name() {
      const user = JSON.parse(localStorage.getItem("user") || "{}");
      return user.full_name || "";
    },
  },
  created() {
    let rawUser = localStorage.getItem("user");
    let user = {};

    if (rawUser) {
      try {
        user = JSON.parse(rawUser);
      } catch (error) {
        console.error("Lỗi khi phân tích dữ liệu người dùng từ localStorage:", error);
        // Xóa dữ liệu hỏng trong localStorage
        localStorage.removeItem("user");
      }
    }

    this.userRole = user.role || "";
    this.userEmail = user.email || "";

    // Thêm sự kiện lắng nghe thay đổi dữ liệu localStorage
    window.addEventListener("storage", this.handleStorageChange);
  },
  methods: {
    handleStorageChange(e) {
      if (e.key === "user") {
        const user = JSON.parse(e.newValue || "{}");
        this.userRole = user.role || "";
        this.userEmail = user.email || "";
      }
    },
    async logout() {
      try {
        localStorage.removeItem("isLoggedIn");
        localStorage.removeItem("user");

        this.userRole = "";
        this.userEmail = "";
        this.menuVisible = false;
        await this.$router.push("/");
        window.location.reload();
      } catch (error) {
        console.error("Lỗi khi đăng xuất:", error);
      }
    },
  },
};
</script>

<style scoped>
.nav-link {
  padding: 0.5rem 1rem;
  color: #4b5563;
  font-weight: 500;
  border-radius: 0.375rem;
  transition: color 200ms;
}

.nav-link:hover {
  color: #2563eb;
}

.nav-link.router-link-active {
  color: #2563eb;
  background-color: #eff6ff;
}

.auth-button {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-weight: 500;
  transition: all 200ms;
}

.auth-button.login {
  background-color: #2563eb;
  color: white;
}

.auth-button.login:hover {
  background-color: #1d4ed8;
}

.auth-button.logout {
  background-color: #ef4444;
  color: white;
}

.auth-button.logout:hover {
  background-color: #dc2626;
}
</style>

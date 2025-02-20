import { createRouter, createWebHistory } from "vue-router";

// Navigation Guards
const authGuard = (to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  if (user.role) {
    next();
  } else {
    next("/auth");
  }
};

const adminGuard = (to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  if (user.role === "admin") {
    next();
  } else {
    next("/");
  }
};

const teacherGuard = (to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  if (user.role === "teacher") {
    next();
  } else {
    next("/");
  }
};

const studentGuard = (to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  if (user.role === "student") {
    next();
  } else {
    next("/auth");
  }
};

const routes = [
  // Public routes
  {
    path: "/",
    component: () => import("@/views/home/Home.vue"),
  },
  {
    path: "/about",
    component: () => import("@/views/home/About.vue"),
  },
  {
    path: "/contact",
    component: () => import("@/views/home/Contact.vue"),
  },
  {
    path: "/auth",
    name: "Auth",
    component: () => import("@/views/auth/Login.vue"),
  },
  {
    path: "/register",
    name: "Register",
    component: () => import("@/views/auth/Registration.vue"),
  },

  // Admin routes
  {
    path: "/admin",
    component: () => import("@/views/admin/dashboard/Admin.vue"),
    beforeEnter: adminGuard,
  },
  {
    path: "/admin/users",
    component: () => import("@/views/admin/user/UserManagement.vue"),
    // beforeEnter: adminGuard,
  },
  {
    path: "/admin/roles",
    component: () => import("@/views/admin/roles/UserAuthorization.vue"),
    beforeEnter: adminGuard,
  },
  {
    path: "/admin/exams",
    component: () => import("@/views/admin/exam/ExamManagement.vue"),
    beforeEnter: adminGuard,
  },
  {
    path: "/admin/notifications",
    component: () =>
      import("@/views/admin/notification/NotificationManagement.vue"),
    beforeEnter: adminGuard,
  },
  {
    path: "/admin/questions",
    component: () => import("@/views/admin/questions/QuestionBank.vue"),
    beforeEnter: adminGuard,
  },
  {
    path: "/admin/results",
    component: () => import("@/views/admin/results/Results.vue"),
    beforeEnter: adminGuard,
  },
  {
    path: "/admin/system-logs",
    component: () => import("@/views/admin/system-logs/SystemLogs.vue"),
    beforeEnter: adminGuard,
  },

  // Teacher routes
  {
    path: "/teacher",
    component: () => import("@/views/teacher/dashboard/TeacherDashboard.vue"),
    beforeEnter: teacherGuard,
  },
  {
    path: "/exam/create",
    component: () => import("@/views/teacher/exam/CreateExam.vue"),
    beforeEnter: teacherGuard,
  },
  {
    path: "/teacher/question-bank",
    component: () => import("@/views/teacher/question/QuestionBank.vue"),
    beforeEnter: teacherGuard,
  },
  {
    path: "/teacher/question-bank/create",
    component: () => import("@/views/teacher/question/CreateQuestion.vue"),
    beforeEnter: teacherGuard,
  },
  {
    path: "/teacher/results",
    component: () => import("@/views/teacher/results/Results.vue"),
    beforeEnter: teacherGuard,
  },

  // Student routes
  {
    path: "/student",
    component: () => import("@/views/student/dashboard/StudentDashboard.vue"),
    beforeEnter: studentGuard,
  },
  {
    path: "/exam",
    component: () => import("@/views/student/exam/Exam.vue"),
    beforeEnter: studentGuard,
  },
  {
    path: "/exampage",
    component: () => import("@/views/student/exam/ExamPage.vue"),
    beforeEnter: studentGuard,
  },
  {
    path: "/my-results",
    component: () => import("@/views/student/exam/ExamResult.vue"),
    beforeEnter: studentGuard,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  const publicPages = ["/", "/auth", "/register", "/about", "/contact"];
  const authRequired = !publicPages.includes(to.path);

  if (authRequired && !user.role) {
    next("/auth");
  } else {
    next();
  }
});

export default router;

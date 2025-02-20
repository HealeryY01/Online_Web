import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://localhost/online-exam-website/backend/api",
  headers: { "Content-Type": "application/json" },
});

export default axiosInstance;

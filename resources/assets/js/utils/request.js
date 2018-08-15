import axios from 'axios';
import store from '../store';
import { getToken } from '~/utils/auth';
import { MessageBox } from 'element-ui';

const TIME_1_SECOND = 1000;
const API_SERVICE_TIMEOUT = 15 * TIME_1_SECOND;

const TOKEN_ABSENT_CODE = 4000;
const TOKEN_EXPIRED_CODE = 4001;
const TOKEN_INVALID_CODE = 4003;

// Create axios instance
const service = axios.create({
  baseURL: process.env.BASE_API,
  timeout: API_SERVICE_TIMEOUT
});

// Request interceptor
service.interceptors.request.use((config) => {
  if (store.getters.token) {
    config.headers.common['Authorization'] = `Bearer ${getToken()}`;
    config.headers.common['Content-Type'] = 'application/x-www-form-urlencoded';
  }
  return config;
}, (error) => {
  console.log(error); // for debug
  Promise.reject(error);
});

// Response interceptor
service.interceptors.response.use((response) => {
  const responseData = response.data;
  if (responseData.success) return responseData.data;
  if ([TOKEN_INVALID_CODE, TOKEN_ABSENT_CODE].includes(responseData.error) ||
    (responseData.error === TOKEN_EXPIRED_CODE && store.getters.token)) {
    MessageBox.confirm(
      'Bạn đã bị đăng xuất, bạn có thể nhấn Hủy để ở lại trang này, hoặc đăng nhập lại',
      'Xác nhận đăng xuất',
      {
        confirmButtonText: 'Đăng nhập lại',
        cancelButtonText: 'Hủy',
        type: 'warning'
      }
    ).then(() => {
      store.dispatch('user/FedLogOut').then(() => {
        location.reload(); // To re-instantiate the vue-router object Avoid bugs
      });
    }).catch(() => {
      // Do nothing
    });
  }
  return Promise.reject(responseData.message);
}, (error) => {
  console.log('err' + error); // for debug
  return Promise.reject(error);
});

export default service;

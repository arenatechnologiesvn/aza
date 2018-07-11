import axios from 'axios';
import { Message, MessageBox } from 'element-ui';
import store from '../store';
import { getToken } from '~/utils/auth';

const TIME_1_SECOND = 1000;
const ERROR_NOTIFY_DURATION_TIME = 5 * TIME_1_SECOND;
const API_SERVICE_TIMEOUT = 15 * TIME_1_SECOND;

const TOKEN_EXPIRED_CODE = 401;
const TOKEN_INVALID_CODE = 402;
const TOKEN_ABSENT_CODE = 403;
const USER_NOT_FOUND = 404;

const setErrorNotify = (error) => {
  return new Message({
    message: error.message,
    type: 'error',
    duration: ERROR_NOTIFY_DURATION_TIME
  });
};

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
  setErrorNotify(responseData);

  if ([TOKEN_INVALID_CODE, TOKEN_ABSENT_CODE, USER_NOT_FOUND].includes(responseData.error) ||
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
      store.dispatch('FedLogOut').then(() => {
        location.reload(); // To re-instantiate the vue-router object Avoid bugs
      });
    });
  }
  return Promise.reject(responseData.message);
}, (error) => {
  console.log('err' + error); // for debug
  return Promise.reject(error);
});

export default service;

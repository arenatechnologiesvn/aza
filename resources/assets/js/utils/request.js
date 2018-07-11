import axios from 'axios';
import { Message, MessageBox } from 'element-ui';
import store from '../store';
import { getToken } from '~/utils/auth';

const TIME_1_SECOND = 1000;
const ERROR_NOTIFY_DURATION_TIME = 5 * TIME_1_SECOND;
const API_SERVICE_TIMEOUT = 15 * TIME_1_SECOND;

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

  // 50008: illegal token; 50012: other client logged in; 50014: Token expired;
  if (responseData.error >= 50000 || (responseData.error === 401 && store.getters.token)) {
    MessageBox.confirm(
      'You have been logged out, you can cancel to stay on this page, or log in again',
      'Confirm logout',
      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }
    ).then(() => {
      store.dispatch('FedLogOut').then(() => {
        location.reload(); // To re-instantiate the vue-router object Avoid bugs
      });
    });
  }
  return Promise.reject('error');
}, (error) => {
  console.log('err' + error); // for debug
  return Promise.reject(error);
});

export default service;

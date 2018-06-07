import axios from 'axios'
import { Message, MessageBox } from 'element-ui'
import store from '../store'
import { getToken } from '~/utils/auth'

const RESPONSE_OK_STATUS = 200
const TIME_1_SECOND = 1000
const set_error_notify = (error) => {
  return Message({
    message: error.message,
    type: 'error',
    duration: 5 * TIME_1_SECOND
  })
}

// Create axios instance
const service = axios.create({
  baseURL: process.env.BASE_API,
  timeout: 15000
})

// Request interceptor
service.interceptors.request.use((config) => {
  if (store.getters.token) {
    config.headers.common['Authorization'] = `Bearer ${getToken()}`
    config.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
  }
  return config
}, (error) => {
  console.log(error) // for debug
  Promise.reject(error)
})

// Response interceptor
service.interceptors.response.use((response) => {
  const status = response.status

  if (response.status === RESPONSE_OK_STATUS) return response.data;

  set_error_notify(response.data.message)
  // 50008: illegal token; 50012: other client logged in; 50014: Token expired;
  if (status >= 500 || (status === 401 && store.getters.token)) {
    MessageBox.confirm('You have been logged out, you can cancel to stay on this page, or log in again', 'Confirm logout', {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning'
    }).then(() => {
      store.dispatch('FedLogOut').then(() => {
        location.reload() // To re-instantiate the vue-router object Avoid bugs
      })
    })
  }
  return Promise.reject('error')
  }, (error) => {
    console.log('err' + error) // for debug
    set_error_notify(error)
    return Promise.reject(error)
  }
)

export default service

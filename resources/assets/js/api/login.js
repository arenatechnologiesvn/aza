import request from '@/utils/request'

export function login(username, password) {
  return request({
    url: '/api/login',
    method: 'post',
    data: {
      email: 'test@test.app',
      password: 'secret'
    }
  })
}

export function getInfo(token) {
  return request({
    url: '/user/info',
    method: 'get',
    params: { token }
  })
}

export function logout() {
  return request({
    url: '/user/logout',
    method: 'post'
  })
}

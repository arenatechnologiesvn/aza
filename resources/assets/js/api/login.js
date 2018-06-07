import request from '~/utils/request'

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
    url: 'api/user/info',
    method: 'get'
  })
}

export function logout() {
  return request({
    url: 'api/logout',
    method: 'post'
  })
}

import request from '~/utils/request';

export function login (email, password) {
  return request({
    url: '/api/login',
    method: 'post',
    data: {
      email: email,
      password: password
    }
  });
}

export function getInfo (token) {
  return request({
    url: 'api/user',
    method: 'get'
  });
}

export function logout () {
  return request({
    url: 'api/logout',
    method: 'post'
  });
}

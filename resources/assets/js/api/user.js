import request from '~/utils/request';

export function update (id, params) {
  return request({
    url: '/api/users/' + id,
    method: 'put',
    data: params
  });
}

export function updateIsActive (id, params) {
  return request({
    url: '/api/users/' + id + '/active',
    method: 'put',
    data: params
  });
}

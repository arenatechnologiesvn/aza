import request from '~/utils/request';

export function all () {
  return request({
    url: '/api/favorites',
    method: 'get'
  });
}

export function add (item) {
  return request({
    url: '/api/favorites',
    method: 'post',
    data: item
  });
}

export function remove (productId) {
  return request({
    url: `/api/favorites/${productId}`,
    method: 'put'
  });
}

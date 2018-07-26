import request from '~/utils/request';

export function all () {
  return request({
    url: '/api/carts',
    method: 'get'
  });
}

export function add (item) {
  return request({
    url: '/api/carts',
    method: 'post',
    data: item
  });
}
export function update (productId, item) {
  return request({
    url: `/api/carts/${productId}`,
    method: 'put',
    data: item
  });
}

export function remove (productId) {
  return request({
    url: `/api/carts/${productId}`,
    method: 'delete'
  });
}

export function checkout (items) {
  return request({
    url: `/api/orders`,
    method: 'post',
    data: items
  });
}

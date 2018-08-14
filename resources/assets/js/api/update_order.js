import request from '~/utils/request';

export function getByOrderId (orderId) {
  return request({
    url: `/api/order_updates/${orderId}`,
    method: 'get'
  });
}

export function addProductToOrder (item) {
  return request({
    url: '/api/order_updates',
    method: 'post',
    data: item
  });
}
export function updateProductToOrder (productId, item) {
  return request({
    url: `/api/order_updates/${productId}`,
    method: 'put',
    data: item
  });
}

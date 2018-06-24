import request from '~/utils/request';

export function getProducts() {
  return request({
    url: '/api/products',
    method: 'get'
  });
}

export function storeProduct(params) {
  return request({
    url: '/api/products',
    method: 'post',
    params: params
  });
}

export function deleteProduct(productId) {
  return request({
    url: `/api/products/${productId}`,
    method: 'delete',
  });
}

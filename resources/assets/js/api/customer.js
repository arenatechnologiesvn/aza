import request from '~/utils/request';

export function bulkCreate (data) {
  return request({
    url: '/api/customers/bulk_create',
    method: 'post',
    data: data
  });
}

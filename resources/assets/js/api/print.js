import request from '~/utils/request';

export function print (id) {
  return request({
    url: `/api/print/${id}`,
    method: 'get'
  });
}

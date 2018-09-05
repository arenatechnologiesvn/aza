import request from '~/utils/request';

export function print (id) {
  return request({
    url: `/api/print/${id}`,
    method: 'get'
  });
}

export function bulkPrint (ids) {
  return request({
    url: `/api/print/select`,
    method: 'put',
    data: {
      ids: ids
    }
  });
}

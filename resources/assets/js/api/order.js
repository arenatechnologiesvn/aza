
import request from '~/utils/request';

export function bulkUpdate (orderIds, data) {
  return request({
    url: '/api/order/bulk_update',
    method: 'put',
    data: {
      ids: orderIds,
      data: data
    }
  });
}

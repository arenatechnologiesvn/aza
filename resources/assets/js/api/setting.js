import request from '~/utils/request';

export function all () {
  return request({
    url: `/api/setting`,
    method: 'get'
  });
}
export function get (key) {
  return request({
    url: `/api/setting/${key}`,
    method: 'get'
  });
}
export function update (key, data) {
  return request({
    url: `/api/setting/${key}`,
    method: 'post',
    data: data
  });
}

import request from '~/utils/request';

export function today () {
  return request({
    url: '/api/clients/today',
    method: 'get'
  });
}

export function byDay (date) {
  return request({
    url: `/api/clients/day/${date}`,
    method: 'get'
  });
}

export function byMonth (month) {
  return request({
    url: `/api/clients/month/${month}`,
    method: 'get'
  });
}

export function byYear (year) {
  return request({
    url: `/api/clients/year/${year}`,
    method: 'get'
  });
}

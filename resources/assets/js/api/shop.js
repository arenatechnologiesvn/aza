import request from '~/utils/request'

export function apiGetList () {
  return request({
    url: '/api/shops',
    method: 'get'
  })
}
export function apiGetById (id) {
  return request({
    url: `/api/shops/${id}`,
    method: 'get'
  })
}

export function apiUpdate (id, model) {
  return request({
    url: `/api/shops/${id}`,
    data: model,
    method: 'put'
  })
}

export function apiCreate (model) {
  return request({
    url: `/api/shops`,
    data: model,
    method: 'post'
  })
}

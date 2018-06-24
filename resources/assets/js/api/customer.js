import request from '~/utils/request'

export function apiGetList () {
  return request({
    url: '/api/customers',
    method: 'get'
  })
}
export function apiGetById (id) {
  return request({
    url: `/api/customers/${id}`,
    method: 'get'
  })
}

export function apiUpdate (id, model) {
  return request({
    url: `/api/customers/${id}`,
    data: model,
    method: 'put'
  })
}

export function apiCreate (model) {
  console.log(model)
  return request({
    url: `/api/customers`,
    data: model,
    method: 'post'
  })
}

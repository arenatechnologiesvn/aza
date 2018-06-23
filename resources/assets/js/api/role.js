import request from '~/utils/request'

export function apiGetList () {
  return request({
    url: '/api/role',
    method: 'get'
  })
}
export function apiGetById (id) {
  return request({
    url: `/api/role/${id}`,
    method: 'get'
  })
}

export function apiUpdate (id, roleModel) {
  return request({
    url: `/api/role/${id}`,
    data: roleModel,
    method: 'put'
  })
}

export function apiCreate (roleModel) {
  return request({
    url: `/api/role`,
    data: roleModel,
    method: 'post'
  })
}

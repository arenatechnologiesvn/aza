import request from '~/utils/request'

export function apiGetList () {
  return request({
    url: '/api/employees',
    method: 'get'
  })
}
export function apiGetById (id) {
  return request({
    url: `/api/employees/${id}`,
    method: 'get'
  })
}

export function apiUpdate (id, employeeModel) {
  return request({
    url: `/api/employees/${id}`,
    data: employeeModel,
    method: 'put'
  })
}

export function apiCreate (employeeModel) {
  return request({
    url: `/api/employees`,
    data: employeeModel,
    method: 'post'
  })
}

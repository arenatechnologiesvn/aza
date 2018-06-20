import request from '~/utils/request'

export function getImages() {
  return request({
    url: '/api/media',
    method: 'get'
  })
}

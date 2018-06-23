import request from '~/utils/request'

export function getMedia(type) {
  return request({
    url: '/api/media',
    method: 'get',
    params: { type: type }
  })
}

export function deleteMedia(type, mediaId) {
  return request({
    url: '/api/media/delete',
    method: 'post',
    params: {
      type: type,
      imageId: mediaId
    }
  })
}

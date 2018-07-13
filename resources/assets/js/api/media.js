import request from '~/utils/request';

const FETCH_MEDIA_URL = '/api/media';
const DELETE_MEDIA_URL = '/api/media/delete';

export function getMedia (type) {
  return request({
    url: FETCH_MEDIA_URL,
    method: 'get',
    params: { type: type }
  });
}

export function deleteMedia (type, mediaId) {
  return request({
    url: DELETE_MEDIA_URL,
    method: 'post',
    params: {
      type: type,
      imageId: mediaId
    }
  });
}

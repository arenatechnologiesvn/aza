import request from '~/utils/request';

export function getProviders() {
  return request({
    url: '/api/provider',
    method: 'get'
  });
}

export function updateProvider(provider) {
  return request({
    url: '/api/provider/update',
    method: 'post',
    params: {
        provider: provider
    }
  });
}

export function deleteProvider(providerId) {
  return request({
    url: '/api/provider/delete',
    method: 'post',
    params: {
      provider_id: providerId 
    }
  });
}

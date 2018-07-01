import request from '~/utils/request';

export function getCategories() {
  return request({
    url: '/api/category',
    method: 'get'
  });
}

export function updateCategory(category) {
  return request({
    url: '/api/category/update',
    method: 'post',
    params: {
      category: category
    }
  });
}

export function deleteCategory(categoryId) {
  return request({
    url: '/api/category/delete',
    method: 'post',
    params: {
      category_id: categoryId 
    }
  });
}

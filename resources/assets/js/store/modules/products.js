import createCrudModule from 'vuex-crud';
import defaultClient from '~/utils/request';
import { Notification } from 'element-ui';
import { bulkCreate } from '~/api/product';

const notifyWrap = (message, type) => {
  Notification({ title: 'Thông báo', message, type });
};

const form = {
  state: {
    formProduct: {
      name: '',
      product_code: '',
      price: '',
      discount_price: '',
      unit: '',
      quantitative: '',
      preview_images: [],
      featured_image: null,
      category_id: '',
      provider_id: '',
      description: ''
    }
  },
  getters: {
    getFormProduct: (state) => {
      return state.formProduct;
    }
  },
  mutations: {
    SET_FORM_PRODUCT: (state, product) => {
      state.formProduct = product;
    }
  },
  actions: {
    setFormProduct ({ commit }, product) {
      commit('SET_FORM_PRODUCT', product);
    },

    bulkCreate ({ commit }, products) {
      return new Promise((resolve, reject) => {
        bulkCreate(products).then(response => {
          notifyWrap('Tải lên sản phẩm thành công', 'success');
          resolve(response);
        }).catch(error => {
          const message = error && error.message;
          notifyWrap(message || 'Tải lên sản phẩm thất bại', 'error');
          reject(error);
        });
      });
    }
  }
};

export default createCrudModule({
  resource: 'products',
  idAttribute: 'id',
  client: defaultClient,
  ...form,
  onFetchListError: () => {
    notifyWrap('Không thể tải xuống danh sách sản phẩm', 'error');
  },
  onCreateSuccess: () => {
    notifyWrap('Tạo sản phẩm thành công', 'success');
  },
  onCreateError: () => {
    notifyWrap('Tạo sản phẩm thất bại', 'error');
  },
  onUpdateSuccess: () => {
    notifyWrap('Cập nhật sản phẩm thành công', 'success');
  },
  onUpdateError: () => {
    notifyWrap('Cập nhật sản phẩm thất bại', 'error');
  },
  onDestroySuccess: () => {
    notifyWrap('Đã xóa sản phẩm', 'success');
  },
  onDestroyError: () => {
    notifyWrap('Xóa sản phẩm thất bại', 'error');
  }
});

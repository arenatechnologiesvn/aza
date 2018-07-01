import createCrudModule from 'vuex-crud';
import defaultClient from '~/utils/request';
import { Message } from 'element-ui';
import dummyImage from '~/assets/login_images/dummy-image.jpg';

const form = {
  state: {
    formProduct: {
      name: '',
      product_code: '',
      price: '',
      discount_price: '',
      unit: '',
      preview_images: dummyImage,
      featured_images: dummyImage,
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
    }
  }
};

export default createCrudModule({
  resource: 'products',
  idAttribute: 'id',
  client: defaultClient,
  ...form,
  onFetchListError: () => {
    Message.error('Không thể tải xuống danh sách sản phẩm');
  },
  onCreateSuccess: () => {
    Message.success('Tạo sản phẩm thành công');
  },
  onCreateError: () => {
    Message.error('Tạo sản phẩm thất bại');
  },
  onUpdateSuccess: () => {
    Message.success('Cập nhật sản phẩm thành công');
  },
  onUpdateError: () => {
    Message.error('Cập nhật sản phẩm thất bại');
  },
  onDestroySuccess: () => {
    Message.success('Đã xóa sản phẩm');
  },
  onDestroyError: () => {
    Message.error('Xóa sản phẩm thất bại');
  }
});

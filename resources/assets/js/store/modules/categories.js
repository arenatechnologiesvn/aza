import createCrudModule from 'vuex-crud';
import defaultClient from '~/utils/request';
import { Message } from 'element-ui';

export default createCrudModule({
  resource: 'categories',
  idAttribute: 'id',
  client: defaultClient,
  onFetchListError: () => {
    Message.error('Không thể tải xuống danh mục sản phẩm');
  },
  onFetchSingleError: () => {
    Message.error('Không thể tải xuống danh mục sản phẩm');
  },
  onCreateSuccess: () => {
    Message.success('Tạo danh mục sản phẩm thành công');
  },
  onCreateError: () => {
    Message.error('Tạo danh mục sản phẩm thất bại');
  },
  onUpdateSuccess: () => {
    Message.success('Cập nhật danh mục sản phẩm thành công');
  },
  onUpdateError: () => {
    Message.error('Cập nhật danh mục sản phẩm thất bại');
  },
  onDestroySuccess: () => {
    Message.success('Đã xóa danh mục sản phẩm');
  },
  onDestroyError: () => {
    Message.error('Xóa danh mục sản phẩm thất bại');
  }
});

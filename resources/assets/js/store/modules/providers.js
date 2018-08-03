import createCrudModule from 'vuex-crud';
import defaultClient from '~/utils/request';
import { Message } from 'element-ui';

export default createCrudModule({
  resource: 'providers',
  idAttribute: 'id',
  client: defaultClient,
  onFetchListError: () => {
    Message.error('Không thể tải xuống danh sách');
  },
  onCreateSuccess: () => {
    Message.success('Thêm mới thành công');
  },
  onCreateError: () => {
    Message.error('Thêm thất bại');
  },
  onUpdateSuccess: () => {
    Message.success('Cập nhật thành công');
  },
  onUpdateError: () => {
    Message.error('Cập nhật thất bại');
  },
  onDestroySuccess: () => {
    Message.success('Xóa thành công');
  },
  onDestroyError: () => {
    Message.error('Xóa thất bại');
  }
});

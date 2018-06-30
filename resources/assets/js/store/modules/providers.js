import createCrudModule from 'vuex-crud';
import defaultClient from '~/utils/request';
import { Message } from 'element-ui';

export default createCrudModule({
  resource: 'providers',
  idAttribute: 'id',
  client: defaultClient,
  onFetchListError: () => {
    Message.error('Không thể tải xuống danh sách nhà cung cấp');
  }
});

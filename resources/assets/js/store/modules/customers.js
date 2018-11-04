import createCrudModule from './crud';
import { bulkCreate } from '~/api/customer';
import { Notification } from 'element-ui';

const extendModule = {
  actions: {
    bulkCreate ({ commit }, customers) {
      return new Promise((resolve, reject) => {
        bulkCreate(customers).then(response => {
          Notification.success({ title: 'Thông báo', message: 'Tải lên khách hàng thành công' });
          resolve(response);
        }).catch(error => {
          Notification.error({ title: 'Thông báo', message: 'Tải lên khách hàng thất bại' });
          reject(error);
        });
      });
    }
  }
};

export default createCrudModule({
  resource: 'customers',
  idAttribute: 'id',
  ...extendModule
});

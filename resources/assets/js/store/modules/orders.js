import createCrudModule from './crud';
import { bulkUpdate } from '~/api/update_order';

const addition = {
  actions: {
    bulkUpdate ({ commit }, { ids, data }) {
      return new Promise((resolve, reject) => {
        bulkUpdate(ids, data).then(response => {
          resolve(response);
        }).catch(error => {
          reject(error);
        });
      });
    }
  }
};

export default createCrudModule({
  resource: 'orders',
  idAttribute: 'id',
  ...addition
});

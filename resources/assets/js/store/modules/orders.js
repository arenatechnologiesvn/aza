import createCrudModule from './crud';
import { bulkUpdate } from '~/api/update_order';
import { print } from '~/api/print';

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
    },
    bill ({ commit }, id) {
      console.log(id)
      return new Promise((resolve, reject) => {
        print(id).then(response => {
          console.log(response)
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

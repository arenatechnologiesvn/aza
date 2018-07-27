import createCrudModule from './crud';
export default createCrudModule({
  resource: 'orders',
  idAttribute: 'id'
});

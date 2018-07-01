import createCrudModule from './crud';
export default createCrudModule({
  resource: 'customers',
  idAttribute: 'id'
});

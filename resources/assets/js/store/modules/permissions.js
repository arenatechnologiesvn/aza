import createCrudModule from './crud';
export default createCrudModule({
  resource: 'permissions',
  idAttribute: 'id'
});

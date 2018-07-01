import createCrudModule from './crud';
export default createCrudModule({
  resource: 'employees',
  idAttribute: 'id'
});

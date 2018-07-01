import Vue from 'vue';
import Vuex from 'vuex';
import app from './modules/app';
import user from './modules/user';
import permission from './modules/permission';
import roles from './modules/roles';
import employees from './modules/employees';
import customers from './modules/customers';
import shops from './modules/shops';
import products from './modules/products';
import categories from './modules/categories';
import providers from './modules/providers';
import common from './modules/common';
import media from './modules/media';
import getters from './getters';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    app,
    user,
    permission,
    employees,
    shops,
    customers,
    roles,
    products,
    categories,
    providers,
    common,
    media
  },
  getters
});

export default store;

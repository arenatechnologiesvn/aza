import Vue from 'vue';
import Vuex from 'vuex';
import app from './modules/app';
import user from './modules/user';
import permission from './modules/permission';
import permissions from './modules/permissions';
import roles from './modules/roles';
import employees from './modules/employees';
import customers from './modules/customers';
import shops from './modules/shops';
import products from './modules/products';
import categories from './modules/categories';
import providers from './modules/providers';
import common from './modules/common';
import media from './modules/media';
import administrative from './modules/administrative';
import getters from './getters';
import cproduct from './modules/cproducts';
import favorite from './modules/favorite';
import cart from './modules/cart';
import orders from './modules/orders';
import report from './modules/report';
Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    app,
    user,
    permission,
    permissions,
    employees,
    shops,
    customers,
    roles,
    products,
    categories,
    providers,
    common,
    media,
    administrative,
    cproduct,
    favorite,
    cart,
    orders,
    report
  },
  getters
});

export default store;

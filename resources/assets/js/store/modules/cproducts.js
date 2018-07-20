import { getProducts, getProductById } from '~/api/products';
import Vue from 'vuex'

const cProducts = {
  namespaced: true,
  state: {
    all: [],
    current: {}
  },
  mutations: {
    SET_PRODUCT (state, products) {
      state.all = products;
    },
    decrementProductInventory (state, { id }) {
      const product = state.all.find(product => product.id === id);
      product.inventory--;
    },
    SET_SINGLE (state, product) {
      state.all.push(product)
    }
  },
  actions: {
    getAllProducts ({ commit }) {
      getProducts().then(products => {
        commit('SET_PRODUCT', products);
      });
    },
    decrementProductInventory (state, { id }) {
      const product = state.all.find(p => p.id === id);
      product.inventory--;
    },
    fetchSingle ({commit}, id) {
      getProductById(id).then(data => {
        commit('SET_SINGLE', data)
      })
    }
  },
  getters: {
    list: (state) => state.all,
    byId: (state) => id => state.all.find(p => p.id == id)
  }
};
export default cProducts;

import { getProducts } from '~/api/products';

const cProducts = {
  namespaced: true,
  state: {
    all: []
  },
  mutations: {
    SET_PRODUCT (state, products) {
      state.all = products;
    },
    decrementProductInventory (state, { id }) {
      const product = state.all.find(product => product.id === id);
      product.inventory--;
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
    }
  },
  getters: {
    list: (state) => state.all
  }
};
export default cProducts;

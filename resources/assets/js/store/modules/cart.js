import _ from 'lodash';
const cart = {
  namespaced: true,
  state: {
    items: [],
    checkoutStatus: null
  },
  mutations: {
    pushProductToCart (state, { id }) {
      state.items.push({
        id,
        quantity: 1
      });
    },
    incrementItemQuantity (state, { id }) {
      const cartItem = state.items.find(item => item.id === id);
      cartItem.quantity++;
    },
    setCartItems (state, { items }) {
      state.items = items;
    },
    setCheckoutStatus (state, status) {
      state.checkoutStatus = status;
    },
    REMOVE_FROM_CART (state, item) {
      state.items = state.items.filter(i => i.id !== item.id);
    }
  },
  actions: {
    addProductToCart ({ state, commit }, product) {
      commit('setCheckoutStatus', null);
      console.log(product)
      if (product.inventory > 0) {
        const cartItem = state.items.find(item => item.id === product.id)
        if (!cartItem) {
          commit('pushProductToCart', { id: product.id });
        } else {
          commit('incrementItemQuantity', cartItem);
        }
        commit('cproduct/decrementProductInventory', { id: product.id }, { root: true });
      }
    },
    removeFromCard ({ commit }, item) {
      commit('REMOVE_FROM_CART', item);
      commit('cproduct/returnProductInventory', item, { root: true });
    },
    checkout ({ commit, state }, products) {
      const savedCartItems = [...state.items];
      console.log(savedCartItems);
      console.log(products);
      commit('setCheckoutStatus', null);
      commit('setCartItems', { items: [] });
    }
  },
  getters: {
    cartProducts: (state, getters, rootState) => state.items.map(({ id, quantity }) => {
      const product = rootState.cproduct.all.find(p => p.id === id);
      return {
        id,
        title: product.title,
        price: product.price,
        img: product.img,
        quantity
      };
    }),
    total: (state) => state.items.length > 0 ? _.map(state.items, 'quantity').reduce((a, b) => a + b) : 0
  }
};
export default cart;

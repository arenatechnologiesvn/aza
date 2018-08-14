import {
  getByOrderId,
  updateProductToOrder,
  addProductToOrder
} from '~/api/update_order';
import Vue from 'vue';

const updateOrder = {
  namespaced: true,
  state: {
    list: [],
    entities: {}
  },
  mutations: {
    ORDER_BY_ID (state, response) {
      const { data } = response;
      data.forEach((m) => {
        Vue.set(state.entities, m['product_id'].toString(), m);
      });
      state.list = data.map(m => m['product_id'].toString());
    },
    DESTROY (state) {
      state.entities = {};
      state.list = [];
    },
    UPDATE (state, item) {
      Vue.set(state.entities, item.product_id.toString(), item);
    },
    DELETE (state, productId) {
      const listIndex = state.list.indexOf(productId.toString());
      if (listIndex >= 0) {
        Vue.delete(state.list, listIndex);
      }
      Vue.delete(state.entities, productId.toString());
    },
    ADD (state, product) {
      Vue.set(state.entities, product.product_id.toString(), product);
      state.list.push(product.product_id.toString());
    }
  },
  actions: {
    fetchByOrderId ({ commit }, orderId) {
      getByOrderId(orderId).then((res) => {
        commit('ORDER_BY_ID', res);
      });
    },
    update ({ commit }, { id, item }) {
      updateProductToOrder(id, item).then(res => {
        commit('UPDATE', res.data);
      });
    },
    delete ({ commit }, { id, item }) {
      updateProductToOrder(id, item).then(res => {
        commit('DELETE', item.product_id);
      });
    },
    add ({ commit }, { item }) {
      addProductToOrder(item).then(res => {
        commit('ADD', res.data);
      });
    },
    destroy ({ commit }) {
      commit('DESTROY');
    }
  },
  getters: {
    products: (state, getters, rootState) => () => {
      return state.list.map((id) => {
        const index = rootState.products.list.find(p => p === state.entities[id].product_id.toString());
        const p = rootState.products.entities[index];
        const img = p && p.featured && `/${p.featured[0].directory}/${p.featured[0].filename}.${p.featured[0].extension}`;
        return p && {
          id,
          title: p.name,
          price: p.price,
          img: img,
          provider: p.provider && p.provider.name,
          quantity: state.entities[id].quantity,
          unit: p.unit,
          order_id: state.entities[id].order_id,
          quantitative: p.quantitative,
          real_price: p.price,
          tmp_price: p.price,
          product_id: id
        } || {};
      });
    },
    getQuantityById: (state) => (id) => {
      return state.entities[id.toString()].quantity;
    }
  }
};
export default updateOrder;

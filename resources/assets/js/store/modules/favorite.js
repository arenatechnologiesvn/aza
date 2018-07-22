import { all, add, remove } from '~/api/favorite';

const favorite = {
  namespaced: true,
  state: {
    items: []
  },
  mutations: {
    pushProductToFavorite (state, id) {
      state.items.push(id);
    },
    REMOVE_FROM_FAVORITE (state, id) {
      const index = state.items.indexOf(id);
      if (index > -1) {
        state.items.splice(index, 1);
      }
    },
    FETCH_LIST_SUCCESS (state, data) {
      console.log(data);
      state.items = data;
    }
  },
  actions: {
    fetchList ({ commit }) {
      all().then(res => {
        commit('FETCH_LIST_SUCCESS', res);
      });
    },
    addProductToFavorite ({ state, commit }, id) {
      add({ product_id: id }).then(res => {
        commit('pushProductToFavorite', id);
        commit('cproduct/addFavorite', id, { root: true });
      });
    },
    removeFromFavorite ({ commit }, id) {
      remove(id).then(res => {
        commit('REMOVE_FROM_FAVORITE', id);
        commit('cproduct/removeFavorite', id, { root: true });
      });
    }
  },
  getters: {
    products: (state, getters, rootState) => state.items.map(id => {
      const product = rootState.cproduct.all.find(p => p.id === id);
      return {
        id,
        title: product.title,
        price: product.price,
        discount: 25000,
        rating: 3,
        img: product.img,
        inventory: product.inventory
      };
    }),
    count: (state) => () => state.items.length
  }
};
export default favorite;

const favorite = {
  namespaced: true,
  state: {
    items: []
  },
  mutations: {
    pushProductToFavorite (state, id) {
      state.items.push(id);
    },
    REMOVE_FROM_FAVORITE (state, item) {
      state.items = state.items.filter(i => i.id !== item.id);
    }
  },
  actions: {
    addProductToFavorite ({ state, commit }, id) {
      commit('pushProductToFavorite', id);
      commit('cproduct/addFavorite', id, { root: true });
    },
    removeFromFavorite ({ commit }, id) {
      commit('REMOVE_FROM_FAVORITE', id);
      commit('cproduct/removeFavorite', id, { root: true });
    }
  },
  getters: {
    products: (state, getters, rootState) => state.items.map(id => {
      const product = rootState.cproduct.all.find(p => p.id === id);
      console.log(id);
      return {
        id,
        title: product.title,
        price: product.price,
        discount: 25000,
        rating: 5,
        img: product.img
      };
    })
  }
};
export default favorite;

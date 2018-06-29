const common = {
  state: {
    product: {
      editId: '',
      openEditPanel: false
    }
  },

  mutations: {
    SET_EDIT_PRODUCT_ID: (state, id) => {
      state.product.editId = id;
    },
    OPEN_PRODUCT_EDIT_PANEL: (state) => {
      state.product.openEditPanel = true;
    },
    CLOSE_PRODUCT_EDIT_PANEL: (state) => {
      state.product.openEditPanel = false;
    }
  },

  actions: {
    setEditProductId ({ commit }, { productId }) {
      commit('SET_EDIT_PRODUCT_ID', productId);
    },
    openProductEditPanel ({ commit }) {
      commit('OPEN_PRODUCT_EDIT_PANEL');
    },
    closeProductEditPanel ({ commit }) {
      commit('CLOSE_PRODUCT_EDIT_PANEL');
    }
  }
};

export default common;

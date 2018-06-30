const common = {
  namespaced: true,

  state: {
    product: {
      editId: '',
      editPanelVisible: false
    },
    media: {
      dialogVisible: false
    }
  },

  mutations: {
    SET_EDIT_PRODUCT_ID: (state, id) => {
      state.product.editId = id;
    },
    OPEN_PRODUCT_EDIT_PANEL: (state) => {
      state.product.editPanelVisible = true;
    },
    CLOSE_PRODUCT_EDIT_PANEL: (state) => {
      state.product.editPanelVisible = false;
    },

    OPEN_MEDIA_MANAGER_MODAL: (state) => {
      state.media.dialogVisible = true;
    },
    CLOSE_MEDIA_MANAGER_MODAL: (state) => {
      state.media.dialogVisible = false;
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
    },

    openMediaManagerModal ({ commit }) {
      commit('OPEN_MEDIA_MANAGER_MODAL');
    },
    closeMediaManagerModal ({ commit }) {
      commit('CLOSE_MEDIA_MANAGER_MODAL');
    }
  }
};

export default common;

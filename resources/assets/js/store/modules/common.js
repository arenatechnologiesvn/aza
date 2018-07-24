import XML from 'pixl-xml';

const common = {
  namespaced: true,

  setIcons (icons) {
    this.state.icons = icons.map((icon) => {
      const symbolParsed = XML.parse(icon.default.content);
      const symbols = symbolParsed.symbol;
      return {
        label: symbolParsed.id,
        options: symbols.map((symbol) => {
          return {
            value: symbol.id.replace('_', ' '),
            label: symbol.id.split('_')[1]
          };
        })
      };
    });
  },

  state: {
    product: {
      editId: '',
      editPanelVisible: false
    },
    media: {
      dialogVisible: false,
      mode: 'single'
    },
    icons: []
  },

  getters: {
    getIcons (state) {
      return state.icons;
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

    OPEN_MEDIA_MANAGER_MODAL: (state, mode) => {
      state.media.dialogVisible = true;
      state.media.mode = mode;
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

    openMediaManagerModal ({ commit }, mode) {
      commit('OPEN_MEDIA_MANAGER_MODAL', mode);
    },
    closeMediaManagerModal ({ commit }) {
      commit('CLOSE_MEDIA_MANAGER_MODAL');
    }
  }
};

export default common;

import crudModule from 'vuex-crud';
import defaultClient from '~/utils/request';
import Vue from 'vue';
import { Notification } from 'element-ui';

const notifyWrap = (message, type) => {
  Notification({ title: 'Thông báo', message, type });
};

const CrudModuleCustom = ({
  idAttribute = 'id',
  resource,
  urlRoot,
  customUrlFn = null,
  state = {},
  actions = {},
  mutations = {},
  getters = {},
  client = defaultClient,
  onFetchListStart = () => {},
  onFetchListSuccess = () => {},
  onFetchListError = () => {},
  onFetchSingleStart = () => {},
  onFetchSingleSuccess = () => {},
  onFetchSingleError = () => {},
  onCreateStart = () => {},
  onCreateSuccess = () => {},
  onCreateError = () => {},
  onUpdateStart = () => {},
  onUpdateSuccess = () => {},
  onUpdateError = () => {},
  onReplaceStart = () => {},
  onReplaceSuccess = () => {},
  onReplaceError = () => {},
  onDestroyStart = () => {},
  onDestroySuccess = () => {},
  onDestroyError = () => {},
  only = ['FETCH_LIST', 'FETCH_SINGLE', 'CREATE', 'UPDATE', 'REPLACE', 'DESTROY'],
  parseList = res => res,
  parseSingle = res => res,
  parseError = res => res
} = {}) => {
  const isUsingCustomUrlGetter = typeof urlRoot === 'function';
  const urlGetter = ({ customUrl, customUrlFnArgs, id }) => {
    if (typeof customUrl === 'string') {
      return `/api/${resource}/` + customUrl;
    } else if (isUsingCustomUrlGetter) {
      const argsArray = Array.isArray(customUrlFnArgs) ? customUrlFnArgs : [customUrlFnArgs];
      const args = [id || null].concat(argsArray);

      return urlRoot(...args);
    }

    return id ? `${urlRoot}/${id}` : urlRoot;
  };

  Object.assign(state, {
    searchquery: {}
  });
  Object.assign(mutations, {
    SET_SEARCHQUERY (state, value) {
      Object.assign(state.searchquery, value);
    },
    DELETE_SELECTION (state, ids) {
      ids.forEach(item => {
        const idIndex = state.list.indexOf(item.toString());
        if (idIndex >= 0) {
          Vue.delete(state.list, idIndex);
        }
        Vue.delete(state.entities, item.toString());
      });
    },
    DELETE_ALL (state) {
      state.list = [];
      state.entities = [];
    }
  });
  Object.assign(actions, {
    search ({ commit }, params) {
      commit('SET_SEARCHQUERY', params);
    },
    deleteSelection ({ commit }, {
      id,
      data,
      config,
      customUrl,
      customUrlFnArgs = []
    } = {}) {
      state.isDestroying = true;
      defaultClient.delete(urlGetter({ id, customUrl, customUrlFnArgs }), data, config).then(res => {
        state.isDestroying = false;
        const ids = res.data || [];
        commit('DELETE_SELECTION', ids);
        notifyWrap('Xóa thành công', 'success');
        return res;
      }).catch(() => {
        state.isDestroying = false;
        notifyWrap('Xóa thất bại', 'error');
      });
    },
    deleteAll ({ commit }, {
      config,
      customUrl,
      customUrlFnArgs = []
    } = {}) {
      state.isDestroying = true;
      defaultClient.delete(urlGetter({ customUrl, customUrlFnArgs }), config).then(res => {
        state.isDestroying = false;
        commit('DELETE_ALL');
        notifyWrap('Xóa thành công', 'success');
        return res;
      }).catch((error) => {
        state.isDestroying = false;
        notifyWrap('Xóa thất bại', 'error');
        return error;
      });
    }
  });

  Object.assign(getters, {
    fetchQuery (state) {
      return state.searchquery;
    }
  });
  return crudModule({
    idAttribute,
    resource,
    urlRoot,
    customUrlFn,
    state,
    actions,
    mutations,
    getters,
    client,
    onFetchListStart,
    onFetchListSuccess,
    onFetchListError,
    onFetchSingleStart,
    onFetchSingleSuccess,
    onFetchSingleError,
    onCreateStart,
    onCreateSuccess,
    onCreateError,
    onUpdateStart,
    onUpdateSuccess,
    onUpdateError,
    onReplaceStart,
    onReplaceSuccess,
    onReplaceError,
    onDestroyStart,
    onDestroySuccess,
    onDestroyError,
    only,
    parseList,
    parseSingle,
    parseError
  });
};
export default CrudModuleCustom;

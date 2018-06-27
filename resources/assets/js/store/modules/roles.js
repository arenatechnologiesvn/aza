import CreateCrudModule from 'vuex-crud'
import defaultClient from '~/utils/request'
import Vue from 'vue'

const roles = {
  state: {
    searchable: {},
    listSearchable: [],
    searchquery: {}
  },
  mutations: {
    SET_SEARCHABLE (state, value) {
      state.searchable = {}
      value.forEach((m) => {
        Vue.set(state.searchable, m['id'].toString(), m)
      })
      state.listSearchable = value.map(m => m['id'].toString())
    },
    SET_SEARCHQUERY (state, value) {
      Object.assign(state.searchquery, value)
    },
    DELETE_SELECTION (state, ids) {
      ids.forEach(item => {
        const idIndex = state.list.indexOf(item.toString())
        if (idIndex >= 0) {
          Vue.delete(state.list, idIndex)
          Vue.delete(state.listSearchable, idIndex)
        }
        Vue.delete(state.entities, item.toString())
        Vue.delete(state.searchable, item.toString())
      })
    }
  },
  actions: {
    search ({ commit }, searchable) {
      commit('SET_SEARCHABLE', searchable)
    },
    deleteSelection ({ commit }, ids) {
      commit('DELETE_SELECTION', ids)
    }
  },
  getters: {
    finder (state) {
      return state.listSearchable.map(id => state.searchable[id.toString()])
    },
    fetchQuery (state) {
      return state.searchquery
    }
  },
  onFetchListSuccess (state, response) {
    const { data } = response
    console.log(data)
    data.forEach((m) => {
      Vue.set(state.searchable, m['id'].toString(), m)
    })
    state.listSearchable = data.map(m => m['id'].toString())
  }
}

export default CreateCrudModule({
  resource: 'roles',
  ...roles,
  idAttribute: 'id',
  client: defaultClient,
  parseList (response) {
    const { data } = response
    return Object.assign({}, response, {
      data: data // expecting array of objects with IDs
    })
  }
})

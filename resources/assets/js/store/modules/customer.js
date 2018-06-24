import { apiGetList, apiGetById, apiUpdate, apiCreate } from '~/api/customer'
// import Vue from 'vue'

const employee = {
  namespaced: true,
  state: {
    entities: [],
    entity: {}
  },
  mutations: {
    SET_LIST: (state, list) => {
      state.entities = list
    },
    SET_ENTITY: (state, entity) => {
      state.entity = entity
    },
    UPDATE: (state, entity) => {
      const indexOf = state.entities.indexOf((item) => item.id === entity.id)
      if (indexOf) {
        state.entities[indexOf] = entity
      }
    },
    CREATE: (state, entity) => {
      state.entities.push(entity)
    }
  },
  actions: {
    getList ({ commit }) {
      return new Promise((resolve, reject) => {
        apiGetList().then(res => {
          commit('SET_LIST', res)
          resolve(res)
        }).catch(err => {
          console.log(err)
          reject(err)
        })
      })
    },
    getById ({ commit }, id) {
      return new Promise((resolve, reject) => {
        apiGetById(id).then(res => {
          commit('SET_ENTITY', res)
          resolve(res)
        }).catch(err => {
          reject(err)
        })
      })
    },
    update ({ commit }, roleModel) {
      return new Promise((resolve, reject) => {
        apiUpdate(roleModel.id, roleModel).then(res => {
          console.log(res)
          commit('UPDATE', res)
          resolve(res)
        }).catch(err => {
          reject(err)
        })
      })
    },
    create ({ commit }, roleModel) {
      return new Promise((resolve, reject) => {
        apiCreate(roleModel).then(res => {
          console.log(res)
          commit('CREATE', res)
          resolve(res)
        }).catch(err => {
          reject(err)
        })
      })
    }
  },
  getters: {
    list: state => state.entities,
    byId: state => id => state.entities.filter(item => item.id === id)[0]
  }
}

export default employee

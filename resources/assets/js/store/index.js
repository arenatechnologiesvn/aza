import Vue from 'vue'
import Vuex from 'vuex'
import app from './modules/app'
import user from './modules/user'
import permission from './modules/permission'
import role from './modules/role'
import roles from './modules/roles'
import employee from './modules/employee'
import customer from './modules/customer'
import shop from './modules/shop'
import getters from './getters'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app,
    user,
    permission,
    role,
    employee,
    shop,
    customer,
    roles
  },
  getters
})

export default store

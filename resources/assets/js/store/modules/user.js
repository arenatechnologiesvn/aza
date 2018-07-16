import { login, logout, getInfo } from '~/api/login';
import { getToken, setToken, removeToken } from '~/utils/auth';
import { constantRouterMap } from '~/router';
const user = {
  state: {
    token: getToken(),
    name: '',
    avatar: '',
    roles: {},
    user_info: {}
  },

  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token;
    },
    SET_NAME: (state, name) => {
      state.name = name;
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar;
    },
    SET_ROLES: (state, roles) => {
      state.roles = roles;
    },
    SET_USER_INFO (state, info) {
      state.user_info = info;
    }
  },

  actions: {
    Login ({ commit }, userInfo) {
      const email = userInfo.email.trim();
      return new Promise((resolve, reject) => {
        login(email, userInfo.password).then(response => {
          const data = response.data;
          setToken(data.token);
          commit('SET_TOKEN', data.token);
          resolve(response);
        }).catch(error => {
          reject(error);
        });
      });
    },

    GetInfo ({ commit, state }) {
      return new Promise((resolve, reject) => {
        getInfo(state.token).then(response => {
          const data = response.data;
          if (data.role) {
            commit('SET_ROLES', data.role);
            commit('SET_USER_INFO', data);
          } else {
            reject('getInfo: role must be a non-null array !');
          }
          commit('SET_NAME', data.name);
          commit('SET_AVATAR', data.photo_url);
          resolve(data);
        }).catch(error => {
          reject(error);
        });
      });
    },

    LogOut ({ commit, state }) {
      return new Promise((resolve, reject) => {
        logout(state.token).then(() => {
          commit('SET_TOKEN', '');
          commit('SET_ROLES', {});
          removeToken();
          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    FedLogOut ({ commit }) {
      return new Promise(resolve => {
        commit('SET_TOKEN', '');
        removeToken();
        resolve();
      });
    }
  }
};

export default user;

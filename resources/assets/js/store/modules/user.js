import { login, logout, getInfo } from '~/api/login';
import { update } from '~/api/user';
import { getToken, setToken, removeToken } from '~/utils/auth';
import dummyImage from '~/assets/login_images/dummy-avatar.png';
import Vue from 'vue';
import { all } from '~/api/setting';

const user = {
  namespaced: true,

  state: {
    token: getToken(),
    name: '',
    avatar: dummyImage,
    roles: {},
    user_info: {},
    settings: {}
  },

  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token;
    },
    SET_NAME: (state, name) => {
      state.name = name;
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar && avatar.length ? avatar[0].url : dummyImage;
    },
    SET_ROLES: (state, roles) => {
      state.roles = roles;
    },
    SET_USER_INFO (state, info) {
      state.user_info = info;
    },
    SET_SETTING: (state, data) => {
      Object.keys(data).forEach(key => {
        Vue.set(state.settings, key, data[key]);
      });
    }
  },

  actions: {
    Settings ({ commit }) {
      return new Promise((resolve, reject) => {
        all().then(res => {
          console.log(res)
          commit('SET_SETTING', res.data);
          resolve(res.data);
        }).catch(err => reject(err));
      });
    },
    Login ({ commit }, userInfo) {
      const email = userInfo.email.trim();
      return new Promise((resolve, reject) => {
        login(email, userInfo.password).then(response => {
          const data = response.data;
          setToken(data.token, userInfo.remember);
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
          commit('SET_AVATAR', data.avatar);
          resolve(data);
        }).catch(error => {
          reject(error);
        });
      });
    },

    Update ({ commit }, { id, params }) {
      return new Promise((resolve, reject) => {
        update(id, params).then(response => {
          resolve(response);
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
          location.reload();
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

import Cookies from 'js-cookie'
import { all } from '~/api/setting';
import Vue from 'vue';
export const getBreadCrumbList = (routeMetched) => {
  let res = routeMetched.map(item => {
    const obj = {
      icon: (item.meta && item.meta.icon) || '',
      name: item.name,
      meta: item.meta
    }
    return obj
  })
  res = res.filter(item => {
    return !item.meta.hideInMenu
  })
  return [{
    name: 'home',
    to: '/home'
  }, ...res]
}

const app = {
  state: {
    sidebar: {
      opened: !+Cookies.get('sidebarStatus'),
      withoutAnimation: false
    },
    device: 'desktop',
    breadCrumbs: [],
    settings: {}
  },
  mutations: {
    TOGGLE_SIDEBAR: state => {
      if (state.sidebar.opened) {
        Cookies.set('sidebarStatus', 1)
      } else {
        Cookies.set('sidebarStatus', 0)
      }
      state.sidebar.opened = !state.sidebar.opened
      state.sidebar.withoutAnimation = false
    },
    setBreadCrumb (state, routeMatched) {
      state.breadCrumbs = getBreadCrumbList(routeMatched)
    },
    CLOSE_SIDEBAR: (state, withoutAnimation) => {
      Cookies.set('sidebarStatus', 1)
      state.sidebar.opened = false
      state.sidebar.withoutAnimation = withoutAnimation
    },
    TOGGLE_DEVICE: (state, device) => {
      state.device = device
    },
    SET_SETTING: (state, data) => {
      Object.keys(data).forEach(key => {
        Vue.set(state.settings, key, data[key]);
      });
    }
  },
  actions: {
    ToggleSideBar: ({ commit }) => {
      commit('TOGGLE_SIDEBAR')
    },
    CloseSideBar({ commit }, { withoutAnimation }) {
      commit('CLOSE_SIDEBAR', withoutAnimation)
    },
    ToggleDevice ({ commit }, device) {
      commit('TOGGLE_DEVICE', device)
    },
    Settings ({ commit }) {
      return new Promise((resolve, reject) => {
        all().then(res => {
          console.log(res)
          commit('SET_SETTING', res.data);
          resolve(res.data);
        }).catch(err => reject(err));
      });
    }
  }
}

export default app

import { asyncRouterMap, asyncRouterMapChild, constantRouterMap } from '~/router';
import { getIntersection } from '~/utils/tools';
import { getMenuByRouter } from '~/utils/util';
/**
 * Determine whether to match the current user authority by meta.role
 * @param role
 * @param route
 */
function hasPermission (role, route) {
  if (route.meta && route.meta.roles) {
    return route.meta.roles.indexOf(role.title) >= 0;
  }

  return true;
}

/**
 * Recursively filter the asynchronous routing table
 * and return the routing table that matches the user's role permissions
 * @param asyncRouterMap
 * @param role
 */
function filterAsyncRouter (asyncRouterMap, role) {
  const accessedRouters = asyncRouterMap.filter(route => {
    if (hasPermission(role, route)) {
      if (route.children && route.children.length) {
        route.children = filterAsyncRouter(route.children, role);
      }

      return true;
    }

    return false;
  });

  return accessedRouters;
}

const permission = {
  state: {
    routers: constantRouterMap,
    addRouters: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      state.addRouters = routers;
      state.routers = getIntersection(constantRouterMap, routers);
    }
  },
  actions: {
    GenerateRoutes ({ commit }, data) {
      return new Promise(resolve => {
        const { role } = data;
        let accessedRouters;
        if (role.title === 'Admin') {
          accessedRouters = asyncRouterMap;
        } else {
          accessedRouters = filterAsyncRouter(asyncRouterMap, role);
        }

        commit('SET_ROUTERS', accessedRouters);
        resolve();
      });
    }
  },
  getters: {
    menuList: (state, getters, rootState) => getMenuByRouter(asyncRouterMapChild, rootState.user.role)
  }
};

export default permission;

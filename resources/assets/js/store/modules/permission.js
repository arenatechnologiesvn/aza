import { asyncRouterMap, constantRouterMap } from '~/router';
import { getIntersection } from '~/utils/tools';
import { getMenuByRouter } from '~/utils/util';
import request from '~/utils/request';
import Layout from '~/views/shared/layout/Admin';

/**
 * Determine whether to match the current user authority by meta.role
 * @param role
 * @param route
 */
// function hasPermission(role, route) {
//   if (route.meta && route.meta.roles) {
//     return route.meta.roles.indexOf(role.title) >= 0;
//   }
//
//   return true;
// }

/**
 * Recursively filter the asynchronous routing table
 * and return the routing table that matches the user's role permissions
 * @param asyncRouterMap
 * @param role
 */
// function filterAsyncRouter(asyncRouterMap, role) {
//   const accessedRouters = asyncRouterMap.filter(route => {
//     if (hasPermission(role, route)) {
//       if (route.children && route.children.length) {
//         route.children = filterAsyncRouter(route.children, role);
//       }
//
//       return true;
//     }
//
//     return false;
//   });
//
//   return accessedRouters;
// }

const processRouter = data => data.map(item => ({
  path: item.path,
  component: () => import(`~/${item.url_action}`),
  redirect: item.redirect ? { name: item.redirect } : null,
  name: item.name,
  meta: {
    title: item.title,
    icon: item.icon,
    show: item.is_show,
    menu: item.is_menu,
    authorize: item.authorize
  },
  children: item.children && processRouter(item.children)
}))

const permission = {
  state: {
    routers: constantRouterMap,
    addRouters: [],
    menus: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      state.addRouters = routers.asyncRouter;
      state.menus = routers.menu;
      state.routers = getIntersection(constantRouterMap, routers.asyncRouter);
    }
  },
  actions: {
    GenerateRoutes ({ commit }, data) {
      return new Promise(resolve => {
        request({
          url: '/api/permissions/roles',
          method: 'get'
        }).then(res => {
          const data = processRouter(res.data);
          const menu = getMenuByRouter(data);
          const asyncRouter = [];
          asyncRouter.push({
            path: '/',
            component: Layout,
            redirect: 'dashboard',
            meta: { title: 'Dashboard', icon: 'fa-solid tachometer-alt' },
            children: [...data]
          });
          asyncRouter.push(...asyncRouterMap);
          commit('SET_ROUTERS', { asyncRouter, menu });
          resolve();
        });
      });
    }
  },
  getters: {
    menuList: state => state.menus
  }
};

export default permission;

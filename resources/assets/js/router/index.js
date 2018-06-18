import Vue from 'vue'
import Router from 'vue-router'

// in development-env not use lazy-loading, because lazy-loading too many pages will cause webpack hot update too slow. so only in production use lazy-loading;
// detail: https://panjiachen.github.io/vue-element-admin-site/#/lazy-loading

Vue.use(Router)

/* Layout */
import Layout from '../views/shared/layout/Admin'
import LayoutGuest from '../views/shared/layout/Guest'

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirct in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    title: 'title'               the name show in submenu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar,
  }
**/
export const constantRouterMap = [
  {
    path: '/login',
    redirect: '/login',
    name: 'login',
    component: LayoutGuest,
    children: [
      {
        path: '/login',
        component: () => import('~/views/pages/auth/Login')
      },
      {
        path: '/forget',
        component: () => import('~/views/pages/auth/Forget')
      }
    ]
  },
  {
    path: '/404', component: () => import('~/views/404'), hidden: true },
  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    name: 'Dashboard',
    hidden: true,
    children: [{
      path: 'dashboard',
      component: () => import('~/views/dashboard/index')
    }]
  }
]

export default new Router({
  mode: 'history',
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap
})

export const asyncRouterMap = [
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Bảng tin',
    meta: { title: 'Bảng tin', icon: 'fa-solid home' },
    children: []
  },
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Quản lý thành viên',
    meta: { title: 'Quản lý thành viên', icon: 'fa-solid user' },
    children: []
  },
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Quản lý sản phẩm',
    meta: { title: 'Quản lý sản phẩm', icon: 'fa-brands codepen' },
    children: []
  },
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Quản lý khách hàng',
    meta: { title: 'Quản lý khách hàng', icon: 'fa-solid user-tie' },
    children: []
    redirect: '/example/table',
    name: 'Example',
    meta: { title: 'Example', icon: 'example' },
    children: [
      {
        path: 'table',
        name: 'Table',
        component: () => import('~/views/table/index'),
        meta: { title: 'Table', icon: 'table' }
      },
      {
        path: 'tree',
        name: 'Tree',
        component: () => import('~/views/tree/index'),
        meta: { title: 'Tree', icon: 'tree', roles: ['Admin'] }
      },
      {
        path: 'form',
        name: 'user_form',
        component: () => import('~/views/pages/users/Form'),
        meta: { title: 'Form', icon: 'form' }
      }
    ]
  },
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Quản lý nhân viên',
    meta: { title: 'Quản lý nhân viên', icon: 'fa-solid users' },
    children: []
  },
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Quản lý đơn hàng',
    meta: { title: 'Quản lý đơn hàng', icon: 'fa-solid box-open' },
    children: []
  },
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Báo cái doanh số',
    meta: { title: 'Báo cái doanh số', icon: 'fa-solid chart-bar' },
    children: []
  },
  {
    path: '/dashboard',
    component: Layout,
    redirect: '/dashboard',
    name: 'Cài đặt hệ thống',
    meta: { title: 'Cài đặt hệ thống', icon: 'fa-solid cog' },
    children: [
      {
        path: 'index',
        name: 'Form',
        component: () => import('~/views/pages/users/Form'),
        meta: { title: 'Form', icon: 'form' }
      }
    ]
  },

  { path: '*', redirect: '/404', hidden: true }
]

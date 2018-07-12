import Vue from 'vue';
import Router from 'vue-router';

// in development-env not use lazy-loading, because lazy-loading too many pages will cause webpack hot update too slow.
// so only in production use lazy-loading.
// detail: https://panjiachen.github.io/vue-element-admin-site/#/lazy-loading

Vue.use(Router);

/* Layout */
import Layout from '../views/shared/layout/Admin';
import ParentView from '~/components/parent-view';
import ClientLayout from '~/views/shared/layout/client/Client';
import AccountParent from '~/views/pages/client/accounts/AccountLayout';

import BaseRouter from './base_router';

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
export default new Router({
  scrollBehavior: () => ({ y: 0 }),
  routes: BaseRouter
});

export const asyncRouterMapChild = [
  {
    path: '/dashboard',
    name: 'dashboard',
    meta: {
      title: 'Dashboard', icon: 'fa-solid tachometer-alt'
    },
    component: () => import('~/views/dashboard/index')
  },
  {
    path: '/products',
    redirect: 'products',
    name: 'ProductContainer',
    component: ParentView,
    meta: { title: 'Quản lý sản phẩm', icon: 'fa-solid home' },
    children: [
      {
        path: '',
        name: 'products',
        component: () => import('~/views/pages/products/Index'),
        meta: {
          title: 'Danh sách sản phẩm',
          icon: 'fa-solid shop',
          roles: ['Admin']
        }
      },
      {
        path: 'add',
        name: 'add_product',
        component: () => import('~/views/pages/products/Create'),
        meta: {
          title: 'Thêm mới sản phẩm',
          icon: 'fa-solid plus',
          roles: ['Admin']
        }
      }
    ]
  },
  {
    path: '/category',
    redirect: 'category',
    name: 'CategoryContainer',
    component: ParentView,
    meta: { title: 'Danh mục sản phẩm', icon: 'fa-solid th-list' },
    children: [
      {
        path: '',
        name: 'category',
        component: () => import('~/views/pages/categories'),
        meta: {
          title: 'Danh sách danh mục',
          icon: 'fa-solid shop',
          roles: ['Admin']
        }
      },
      {
        path: 'add',
        name: 'add_category',
        component: () => import('~/views/pages/categories/Create'),
        meta: {
          title: 'Thêm mới danh mục',
          icon: 'fa-solid shop',
          roles: ['Admin']
        }
      },
      {
        path: ':id',
        name: 'update_category',
        component: () => import('~/views/pages/categories/Create'),
        hidden: true,
        meta: {
          title: 'Cập nhật danh mục',
          icon: 'fa-solid shop',
          roles: ['Admin']
        }
      }
    ]
  },
  {
    path: '/users',
    redirect: 'roles',
    component: ParentView,
    name: 'AccountContainer',
    meta: { title: 'Quản lý tài khoản', icon: 'fa-solid user' },
    children: [
      {
        path: '',
        name: 'roles',
        component: () => import('~/views/pages/roles/Index'),
        meta: {
          title: 'Danh sách quyền',
          icon: 'fa-solid lock'
        }
      },
      {
        path: ':id',
        name: 'role_update',
        component: () => import('~/views/pages/roles/Update'),
        hidden: true,
        meta: {
          title: 'Cập nhật quyền',
          icon: 'fa-solid lock'
        }
      },
      {
        path: 'add',
        name: 'role_create',
        component: () => import('~/views/pages/roles/Create'),
        hidden: true,
        meta: {
          title: 'Thêm mới quyền',
          icon: 'fa-solid lock'
        }
      }
    ]
  },
  {
    path: '/employees',
    redirect: 'employees',
    component: ParentView,
    name: 'EmployeeContainer',
    meta: { title: 'Quản lý Nhân viên', icon: 'fa-solid users' },
    children: [
      {
        path: '',
        name: 'employees',
        component: () => import('~/views/pages/employees/Index'),
        meta: {
          title: 'Danh sách nhân viên',
          icon: 'fa-solid users'
        }
      },
      {
        path: ':id(\\d+)',
        name: 'employee_update',
        component: () => import('~/views/pages/employees/Update'),
        hidden: true,
        meta: {
          title: 'Cập nhật nhân viên',
          icon: 'fa-solid lock'
        }
      },
      {
        path: 'add',
        name: 'employee_create',
        component: () => import('~/views/pages/employees/Create'),
        meta: {
          title: 'Thêm mới nhân viên',
          icon: 'fa-solid lock'
        }
      }
    ]
  },
  {
    path: '/customers',
    redirect: 'customers',
    component: ParentView,
    name: 'CustomerContainer',
    meta: { title: 'Quản lý khách hàng', icon: 'fa-solid user' },
    children: [
      {
        path: '',
        name: 'customers',
        component: () => import('~/views/pages/customers/Index'),
        meta: {
          title: 'Danh sách khách hàng',
          icon: 'fa-solid users'
        }
      },
      {
        path: ':id(\\d+)',
        name: 'customer_update',
        component: () => import('~/views/pages/customers/Update'),
        hidden: true,
        meta: {
          title: 'Cập nhật khách hàng',
          icon: 'fa-solid lock'
        }
      },
      {
        path: 'add',
        name: 'customer_create',
        component: () => import('~/views/pages/customers/Create'),
        meta: {
          title: 'Thêm mới khách hàng',
          icon: 'fa-solid lock'
        }
      }
    ]
  },
  {
    path: '/shops',
    redirect: 'shops',
    component: ParentView,
    name: 'ShopContainer',
    meta: { title: 'Quản lý cừa hàng', icon: 'fa-solid store' },
    children: [
      {
        path: '',
        name: 'shops',
        component: () => import('~/views/pages/shops/Index'),
        meta: {
          title: 'Danh sách cửa hàng',
          icon: 'fa-solid store'
        }
      },
      {
        path: ':id(\\d+)',
        name: 'shop_update',
        component: () => import('~/views/pages/shops/Update'),
        hidden: true,
        meta: {
          title: 'Cập nhật cừa hàng',
          icon: 'fa-solid lock'
        }
      },
      {
        path: 'add',
        name: 'shop_create',
        component: () => import('~/views/pages/shops/Create'),
        meta: {
          title: 'Thêm mới cừa hàng',
          icon: 'fa-solid lock'
        }
      }
    ]
  },
  {
    path: '/providers',
    redirect: 'providers',
    component: ParentView,
    name: 'ProviderContainer',
    meta: { title: 'Quản lý nhà cung cấp', icon: 'fa-solid truck' },
    children: [
      {
        path: '',
        name: 'providers',
        component: () => import('~/views/pages/providers'),
        meta: {
          title: 'Danh sách nhà cung cấp',
          icon: 'fa-solid truck'
        }
      },
      {
        path: 'add',
        name: 'providers_create',
        component: () => import('~/views/pages/providers/Create'),
        meta: {
          title: 'Thêm mới nhà cung cấp',
          icon: 'fa-solid lock'
        }
      }
    ]
  }
];
export const asyncRouterMap = [
  {
    path: '/',
    component: Layout,
    redirect: 'dashboard',
    meta: { title: 'Dashboard', icon: 'fa-solid tachometer-alt' },
    children: [...asyncRouterMapChild]
  },
  {
    path: '/home',
    component: ClientLayout,
    redirect: 'home',
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('~/views/pages/client/Home'),
        meta: {
          title: 'Trang chủ',
          icon: 'fa-solid home'
        }
      },
      {
        path: 'products',
        name: 'home_product',
        component: () => import('~/views/pages/client/Products'),
        meta: {
          title: 'SẢN PHẨM',
          icon: 'fa-solid home'
        }
      },
      {
        path: 'products/:id',
        name: 'product_detail',
        component: () => import('~/views/pages/client/ProductDetail'),
        meta: {
          title: 'SẢN PHẨM MỚI',
          icon: 'fa-solid home'
        }
      },
      {
        path: 'accounts',
        name: 'home_account',
        component: AccountParent,
        redirect: '/home/accounts',
        meta: {
          title: 'TÀI KHOẢN'
        },
        children: [
          {
            path: '',
            name: 'home_account_index',
            component: () => import('~/views/pages/client/accounts/pages/Index'),
            meta: {
              title: 'THÔNG TIN CÁ NHÂN',
              icon: 'fa-solid user'
            }
          },
          {
            path: 'alert',
            name: 'home_account_alert',
            component: () => import('~/views/pages/client/accounts/pages/Alert'),
            meta: {
              title: 'THÔNG BÁO CÁ NHÂN',
              icon: 'fa-solid bell'
            }
          },
          {
            path: 'order',
            name: 'home_account_order',
            component: () => import('~/views/pages/client/accounts/pages/Order'),
            meta: {
              title: 'QUẢN LÝ ĐƠN HÀNG',
              icon: 'fa-solid cart'
            }
          },
          {
            path: 'favorite',
            name: 'home_account_favorite',
            component: () => import('~/views/pages/client/accounts/pages/Favorite'),
            meta: {
              title: 'SẢN PHẨM YÊU THÍCH',
              icon: 'fa-solid heart'
            }
          }
        ]
      }
    ]
  },
  // {
  //   path: '/dashboard8',
  //   component: Layout,
  //   redirect: '/dashboard',
  //   name: 'Quản lý sản phẩm',
  //   meta: { title: 'Quản lý sản phẩm', icon: 'fa-brands codepen' },
  //   children: []
  // },
  // {
  //   path: '/dashboard0',
  //   component: Layout,
  //   redirect: '/dashboard',
  //   name: 'Quản lý khách hàng',
  //   meta: { title: 'Quản lý khách hàng', icon: 'fa-solid user-tie' },
  //   children: [
  //     {
  //       path: 'table',
  //       name: 'Table',
  //       component: () => import('~/views/table/index'),
  //       meta: { title: 'Table', icon: 'table' }
  //     },
  //     {
  //       path: 'tree',
  //       name: 'Tree',
  //       component: () => import('~/views/tree/index'),
  //       meta: { title: 'Tree', icon: 'tree', roles: ['Admin'] }
  //     },
  //     {
  //       path: 'form',
  //       name: 'user_form',
  //       component: () => import('~/views/pages/users/Form'),
  //       meta: { title: 'Form', icon: 'form' }
  //     }
  //   ]
  // },
  // {
  //   path: '/dashboard1',
  //   component: Layout,
  //   redirect: '/dashboard',
  //   name: 'Quản lý nhân viên',
  //   meta: { title: 'Quản lý nhân viên', icon: 'fa-solid users' },
  //   children: []
  // },
  // {
  //   path: '/dashboard2',
  //   component: Layout,
  //   redirect: '/dashboard',
  //   name: 'Quản lý đơn hàng',
  //   meta: { title: 'Quản lý đơn hàng', icon: 'fa-solid box-open' },
  //   children: []
  // },
  // {
  //   path: '/form',
  //   component: Layout,
  //   redirect: '/form',
  //   name: 'Báo cái doanh số',
  //   meta: { title: 'Báo cái doanh số', icon: 'fa-solid chart-bar' },
  //   children: [
  //     {
  //       path: 'index',
  //       name: 'Form',
  //       component: () => import('~/views/pages/users/Form'),
  //       meta: { title: 'Form', icon: 'form' }
  //     }
  //   ]
  // },
  // {
  //   path: '/dashboard4',
  //   component: Layout,
  //   redirect: '/dashboard',
  //   name: 'Cài đặt hệ thống',
  //   meta: { title: 'Cài đặt hệ thống', icon: 'fa-solid cog' },
  //   children: [
  //     {
  //       path: 'index',
  //       name: 'Form',
  //       component: () => import('~/views/pages/users/Form'),
  //       meta: { title: 'Form', icon: 'form' }
  //     }
  //   ]
  // },
  { path: '*', redirect: '/404', hidden: true }
];

export const constantRouterMap = BaseRouter;

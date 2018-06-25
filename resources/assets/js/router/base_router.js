import LayoutGuest from '../views/shared/layout/Guest';
const ConstBaseRouterMap = [
  {
    path: '/login',
    redirect: '/login',
    name: 'login',
    component: LayoutGuest,
    hidden: true,
    children: [
      {
        path: '/login',
        component: () => import('~/views/pages/auth/Login'),
        hidden: true
      },
      {
        path: '/forget',
        component: () => import('~/views/pages/auth/Forget'),
        hidden: true
      }
    ]
  },
  {
    path: '/404', component: () => import('~/views/errors/404'), hidden: true
  },
  {
    path: '/401', component: () => import('~/views/errors/401'), hidden: true
  },
  {
    path: '/500', component: () => import('~/views/errors/500'), hidden: true
  }
];
export default ConstBaseRouterMap;

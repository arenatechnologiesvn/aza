import router from './router';
import store from './store';
import { Message } from 'element-ui';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import { getToken } from '~/utils/auth';

NProgress.configure({ showSpinner: false });

const whiteList = ['/login', '/forget'];

router.beforeEach((to, from, next) => {
  // Start routing bar
  NProgress.start();

  if (getToken()) {
    if (to.path === '/login') {
      next({ path: '/' });

      // if current page is dashboard will not trigger afterEach hook, so manually handle it
      NProgress.done();
    } else {
      if (!store.getters.roles.title) {
        store.dispatch('GetInfo').then(res => {
          const role = res.role;
          // Generates an accessible routing table based on roles permission
          store.dispatch('GenerateRoutes', { role }).then(() => {
            // Add dynamically accessible routing tables
            router.addRoutes(store.getters.addRouters);
            // console.log(store.getters.addRouters);

            // Hack method to ensure that addRoutes is complete
            // Set the replace: true so the navigation will not leave a history record
            next({ ...to, replace: true });
          });
        }).catch((err) => {
          store.dispatch('FedLogOut').then(() => {
            Message.error(err || 'Verification failed, please login again');
            next({ path: '/' });

            // if current page is login will not trigger afterEach hook, so manually handle it
            NProgress.done();
          });
        });
      } else {
        next();
      }
    }
  } else {
    /* has no token*/

    if (whiteList.indexOf(to.path) !== -1) {
      // In the log-in white list, enter directly
      next();
    } else {
      // Otherwise all redirect to login page
      next('/login');

      // if current page is login will not trigger afterEach hook, so manually handle it
      NProgress.done();
    }
  }
});

// Finish progress bar
router.afterEach(() => {
  NProgress.done();
});

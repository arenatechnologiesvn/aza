const getters = {
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  token: state => state.user.token,
  avatar: state => state.user.avatar,
  name: state => state.user.name,
  roles: state => state.user.roles,
  isAdmin: state => state.user && state.user.roles && state.user.roles === 'Admin',
  user_info: state => state.user.user_info,
  permission_routers: state => state.permission.routers,
  addRouters: state => state.permission.addRouters,
  settings: state => state.user.settings
};

export default getters;

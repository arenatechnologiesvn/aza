<template lang="pug">
  el-scrollbar(wrapClass="scrollbar-wrapper")
    div.logo-container(v-if="sidebar.opened" style="height: 250px;")
      div.logo-content
        img.logo-image(:src="fake_avatar")
        span.logo-name LINH NGUYỄN
        span.logo-description Quản trị viên cao cấp
    el-menu(
      mode="vertical"
      :show-timeout="200"
      :default-active="$route.path"
      :collapse="isCollapse"
      background-color="#001C2C"
      text-color="#bfcbd9"
      active-text-color="#409EFF"
    )
      sidebar-item(:routes="permission_routers")
</template>

<script>
import { mapGetters } from 'vuex'
import SidebarItem from './SidebarItem'
import fake_avatar from '~/assets/login_images/linh-nguyen.jpg'

export default {
  components: { SidebarItem },
  data() {
    return {
      fake_avatar
    }
  },
  computed: {
    ...mapGetters([
      'permission_routers',
      'sidebar',
      'avatar',
      'name'
    ]),
    isCollapse() {
      return !this.sidebar.opened
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.logo-container {
  position: relative;
  background-color: #001C2C;
  border-top: 2px solid #122840;
  .logo-content {
    position: relative;
    margin: 0 auto;
    text-align: center;
    padding-top: 40px;

    span {
      display: block;
      margin: 10px auto;
      height: 15px;
      font-size: 15px;
    }
  }
  .non-collapse {
    height: 160px !important;
  }

  .logo-image {
    height: 125px;
    width: 125px;
    display: block;
    margin: 0 auto;
    border-radius: 50%;
  }
  .logo-name {
    color: #fff;
  }
  .logo-description {
    color: #484f55;
  }
}
</style>

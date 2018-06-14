<template lang="pug">
  el-menu.navbar(mode="horizontal")
    hamburger.hamburger-container(:toggleClick="toggleSideBar" :isActive="sidebar.opened")
    breadcrumb
    el-dropdown.avatar-container(trigger="click")
      el-row.avatar-wrapper(type="flex" class="row-bg" justify="space-between" align="middle")
        img.user-avatar(:src="avatar")
        span(style="margin-left: 10px") {{ name }}
        i.el-icon-caret-bottom
      el-dropdown-menu.user-dropdown(slot="dropdown")
        router-link(class="inlineBlock" to="/")
          el-dropdown-item Trang chủ
        el-dropdown-item(divided)
          span(@click="logout" style="display:block;") Đăng xuất
</template>

<script>
import { mapGetters } from 'vuex'
import Breadcrumb from '~/components/Breadcrumb'
import Hamburger from '~/components/Hamburger'

export default {
  components: {
    Breadcrumb,
    Hamburger
  },
  computed: {
    ...mapGetters([
      'sidebar',
      'name',
      'avatar'
    ])
  },
  methods: {
    toggleSideBar() {
      this.$store.dispatch('ToggleSideBar')
    },
    logout() {
      this.$store.dispatch('LogOut').then(() => {
        location.reload() // 为了重新实例化vue-router对象 避免bug
      })
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.navbar {
  height: 50px;
  line-height: 50px;
  border-radius: 0px !important;
  .hamburger-container {
    line-height: 58px;
    height: 50px;
    float: left;
    padding: 0 10px;
  }
  .screenfull {
    position: absolute;
    right: 90px;
    top: 16px;
    color: red;
  }
  .avatar-container {
    height: 50px;
    display: inline-block;
    position: absolute;
    right: 35px;
    .avatar-wrapper {
      cursor: pointer;
      position: relative;
      .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
      }
      .el-icon-caret-bottom {
        position: absolute;
        right: -20px;
        font-size: 12px;
      }
    }
  }
}
</style>


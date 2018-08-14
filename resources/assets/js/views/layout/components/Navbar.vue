<template lang="pug">
  el-menu.navbar(mode="horizontal")
    el-row.logo-container(type="flex" justify="center" align="middle" :class="!sidebar.opened ? 'collapse' : 'non-collapse'")
      img.logo-image(:src="avatar")
      span.logo-title(v-if="sidebar.opened") PROJECT
    hamburger.hamburger-container(:toggleClick="toggleSideBar" :isActive="sidebar.opened")
    el-dropdown.avatar-container(trigger="click")
      el-row.avatar-wrapper(type="flex" class="row-bg" justify="space-between" align="middle")
        img.user-avatar(:src="avatar")
        span(style="margin-left: 10px") LINH NGUYỄN
        i.el-icon-caret-bottom
      el-dropdown-menu.user-dropdown(slot="dropdown")
        router-link(class="inlineBlock" to="/home")
          el-dropdown-item Trang chủ
        el-dropdown-item(divided)
          span(@click="logout" style="display:block;") Đăng xuất
</template>

<script>
import { mapGetters } from 'vuex'
import Hamburger from '~/components/Hamburger'

export default {
  components: {
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
      this.$store.dispatch('user/LogOut').then(() => {
        this.$router.push({path: '/'})
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
  box-shadow: 2px 4px 20px -4px rgba(0,0,0,.3);
  z-index: 9;
  width: 100%;
  position: fixed;
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
  .logo-container {
    float: left;
    background-color: #001C2C;
    height: 50px;
    .logo-image {
      height: 40px;
      width: 40px;
    }
    .logo-title {
      margin-left: 10px;
      font-weight: bold;
      color: #71a42c;
    }
  }
  .collapse {
    width: 50px;
  }
  .non-collapse {
    width: 250px;
  }
}
</style>


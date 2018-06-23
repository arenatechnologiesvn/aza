<template lang="pug">
  nav(class="header navbar el-menu--horizontal el-menu" :class="!sidebar.opened ? 'collapsed' : ''")
    div.header__logo
      el-row.logo-container(type="flex" justify="center" align="middle")
        img.logo__image(:src="logo_img")
        span.logo__title(v-if="sidebar.opened") PROJECT
    div.header__control
      div.bars-container
        bars(:toggleClick="toggleSideBar" :isActive='sidebar.opened')
      div.header__info
        el-badge(:value="10" class="item")
          svg-icon(icon-class="fa-solid bell")
        el-dropdown(trigger="click")
          div.navbar-right
            div.img-container
              img.user__avatar(:src="avatar")
            div.user__info
              span {{ name }}
              i.el-icon-caret-bottom
          el-dropdown-menu.user-dropdown(slot="dropdown")
            el-dropdown-item
              router-link(class="inlineBlock" to="/") Trang chủ
            el-dropdown-item(divided)
            el-dropdown-item
              span(@click="logout" style="display:block;") Đăng xuất
</template>

<script>
  import { mapGetters } from 'vuex'
  import Bars from '~/components/Hamburger'
  import logo_img from '~/assets/login_images/logo-login-page.png'
  import ElBadge from "element-ui/packages/badge/src/main";

  export default {
    name: 'Navbar',
    components: {
      ElBadge,
      Bars
    },
    data() {
      return {
        logo_img
      }
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
          this.$router.push({path: '/login'})
        })
      }
    }
  }
</script>
<template lang="pug">
  el-container.main__container(direction="horizontal")
    el-aside.sidebar__container(:class="collapsed ? 'collapsed':''")
      sidebar(:collapse="collapsed" :menuList="menuList" :active-name="$route.name" @on-select="turnToPage")
        div.logo-con(slot="logo")
          img(:src="logo" key="max-logo")
          span.logo__title(v-show="!collapsed") PROJECT
    el-container(style="overflow-x: hidden;")
      el-header.header__container(height="64px")
        navbar(:collapsed="collapsed" @on-coll-change="handleCollapsedChange" :listBreadcrumb="listBreadcrumb")
          div.account-con
            navbar-account(:avatar="logo")
      el-main
        app-main
</template>

<script>
  import '~/style/admin.scss'
  import './admin.scss'
  import { mapGetters } from 'vuex'
  import AppMain from '../components/AppMain'
  import ResizeMixin from '../mixin/ResizeHandler'
  import Navbar from './components/Navbar'
  import Sidebar from './components/Sidebar'
  import logo from '~/assets/login_images/logo-login-page.png'
  import NavbarAccount from './components/User'

  export default {
    name: "admin",
    mixins: [ResizeMixin],
    components: {
      AppMain,
      Navbar,
      Sidebar,
      NavbarAccount
    },
    data () {
      return {
        collapsed: false,
        logo,
        listBreadcrumb: [
          {
            name: 'index',
            path: '/index',
            meta: {
              icon: 'fa-solid home',
              title: 'Trang chủ'
            }
          },
          {
            name: 'user',
            path: '/user',
            meta: {
              icon: 'fa-solid bell',
              title: 'Danh bạ'
            }
          }
        ]
      }
    },
    computed: {
      ...mapGetters([
        'name',
        'roles'
      ]),
      sidebar() {
        return this.$store.state.app.sidebar
      },
      device() {
        return this.$store.state.app.device
      },
      classObj() {
        return {
          hideSidebar: !this.sidebar.opened,
          withoutAnimation: this.sidebar.withoutAnimation,
          mobile: this.device === 'mobile'
        }
      },
      menuList () {
        return this.$store.getters.menuList
      }
    },
    methods: {
      handleCollapsedChange (state) {
        this.collapsed = state
      },
      turnToPage (name) {
        this.$router.push({
          name: name
        })
      }
    },
    created () {
      console.log(this.menuList)
    }
  }
</script>

<style lang="scss" scoped>
  .sidebar {
    width: 250px;
  }
</style>
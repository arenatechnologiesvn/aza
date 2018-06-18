<template lang="pug">
  el-container(:class="classObj")
    div.drawer-bg(v-if="device==='mobile'&&sidebar.opened" @click="handleClickOutside")
    el-header(style="padding: 0" height="50px")
      navbar
    el-container
      el-aside(width="auto")
        sidebar
      el-main
        bread-crumb
        div.line(style="margin: 5px 0;")
        div.main-content
          app-main
    el-footer
</template>

<script>
  import '~/style/admin.scss'
  import AppMain from '../components/AppMain'
  import BreadCrumb from '~/components/Breadcrumb'
  import ResizeMixin from '../mixin/ResizeHandler'
  import Navbar from '../components/Navbar'
  import Sidebar from '../components/Sidebar'
  import ElContainer from "element-ui/packages/container/src/main";

  export default {
    name: "admin",
    mixins: [ResizeMixin],
    components: {
      ElContainer,
      AppMain,
      BreadCrumb,
      Navbar,
      Sidebar
    },
    computed: {
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
      }
    },
    methods: {
      handleClickOutside() {
        this.$store.dispatch('CloseSideBar', { withoutAnimation: false })
      }
    }
  }
</script>

<style lang="scss" scoped>
  .sidebar {
    width: 250px;
  }
</style>
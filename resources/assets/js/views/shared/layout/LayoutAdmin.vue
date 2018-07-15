<template lang="pug">
  <router-view></router-view>
</template>

<script>
  import '~/style/admin.scss'
  import './admin.scss'
  import { mapGetters, mapMutations } from 'vuex'
  import AppMain from '../components/AppMain'
  import ResizeMixin from '../mixin/ResizeHandler'
  import Navbar from './components/Navbar'
  import Sidebar from './components/Sidebar'
  import logo from '~/assets/login_images/logo-login-page.png'
  import NavbarAccount from './components/User'

  export default {
    components: {
      AppMain
    },
    name: 'LayoutAdmin',
    mixins: [ResizeMixin]
  }
</script>

<style scoped>

</style>
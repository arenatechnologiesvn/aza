<template lang="pug">
  div.navbar
    nav-top
    div.main.container
      logo
      nav-menu.nav__menu(:isShow="isShow")
      span(class="show-xs control" @click="toggleShow")
        svg-icon(:icon-class="isShow ? 'fa-solid times' : 'fa-solid bars'")
      form-search
</template>

<script>
  import NavTop from './NavTop'
  import Logo from './Logo'
  import NavMenu from './NavMenu'
  import FormSearch from './FormSearch'
  import './navbar.scss'
  export default {
    name: 'NavbarIndex',
    components: {
      NavTop,
      Logo,
      NavMenu,
      FormSearch
    },
    data () {
      return {
        isShow: false
      }
    },
    methods: {
      toggleShow () {
        this.isShow = !this.isShow
      }
    }
  }
</script>

<style scoped>

</style>
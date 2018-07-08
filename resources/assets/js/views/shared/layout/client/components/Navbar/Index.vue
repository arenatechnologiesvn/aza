<template lang="pug">
  div.navbar
    nav-top
    div.main.container
      logo
      nav-menu.nav__menu
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
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div.logo__container
    div.img__container
      img.logo(:src="logo")
    span.name__container
      span.logo__aza AZAVN.
      span.logo__com COM
</template>

<script>
  import logo from '~/assets/login_images/logo-login-page.png'
  export default {
    name: 'LogoNavbar',
    data () {
      return {
        logo
      }
    }
  }
</script>

<style scoped>

</style>
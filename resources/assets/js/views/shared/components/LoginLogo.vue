<template lang="pug">
  div.logo
    img(:src="logo_img")
</template>

<script>
  import logo_img from '~/assets/login_images/logo-login-page.png'

  export default {
    name: 'LoginLogo',
    data () {
      return {
        logo_img
      }
    }
  }
</script>

<style scoped>

</style>
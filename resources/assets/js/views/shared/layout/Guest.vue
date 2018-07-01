<template lang="pug">
  div.guest__layout
    div.main-wrapper
      login-logo
      app-main
      guest-footer
</template>

<script>
  import AppMain from "../components/AppMain"
  import GuestFooter from "../components/GuestFooter"
  import LoginLogo from "../components/LoginLogo";
  import '~/style/guest.scss'

  export default {
    components: {
      LoginLogo,
      GuestFooter,
      AppMain
    },
    name: 'GuestLayout'
  }
</script>
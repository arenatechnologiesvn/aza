<template lang="pug">
  div.footer
    footer-info.container
    div.line
    copyright.container
</template>

<script>
  import Copyright from './Social'
  import FooterInfo from './FooterInfo'
  import './footer.scss'
  export default {
    name: 'Footer',
    components: {
      Copyright,
      FooterInfo
    }
  }
</script>

<style scoped>

</style>
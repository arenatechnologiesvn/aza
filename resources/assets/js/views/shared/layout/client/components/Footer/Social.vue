<template lang="pug">
  div.social__container
    el-row(type="flex")
      el-col(:span="12")
        span {{copyright}}
        br
        span Powered by Arena App
      el-col.social(:span="12" style="text-align: right;")
        span.facebook
          svg-icon(icon-class="fa-brands facebook-f")
        span.gplus
          svg-icon(icon-class="fa-brands google-plus")
        span.twitter
          svg-icon(icon-class="fa-brands twitter")
</template>

<script>
  export default {
    name: 'FooterSocial',
    computed: {
      copyright () {
        return this.$store.getters.settings.company &&
          this.$store.getters.settings.company.copyright
      }
    }
  }
</script>

<style scoped>

</style>
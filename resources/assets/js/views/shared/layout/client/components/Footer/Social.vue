<template lang="pug">
  div.social__container
    el-row(type="flex")
      el-col(:span="12")
        span Copyright © Công Ty Cổ Phần Thịn Thế, All right reversed.
        br
        span Powered by Arena App
      el-col.social(:span="12" style="text-align: right;")
        span.facebook
          svg-icon(icon-class="fa-solid won-sign")
        span.gplus
          svg-icon(icon-class="fa-solid won-sign")
        span.twitter
          svg-icon(icon-class="fa-solid won-sign")
</template>

<script>
  export default {
    name: 'FooterSocial'
  }
</script>

<style scoped>

</style>
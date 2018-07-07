<template lang="pug">
  div.footer-info__container
    el-row(type="flex")
      el-col(:span="6" v-for="item in 4" :key="item")
        info-item
          template(slot="footer-content")
            ul.footer-info__content
              li(v-for="liItem in 3" :key="liItem")
                strong ĐC:
                span 686/22/11/ Nguyễn Đình Chiểu, Phường 11, QUận 3, TPHCM
</template>

<script>
  import InfoItem from './InfoItem'
  export default {
    name: 'FooterInfo',
    components: {
      InfoItem
    }
  }
</script>

<style scoped>

</style>
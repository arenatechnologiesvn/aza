<template lang="pug">
  div.slogan__container
    el-row(:gutter="50")
      el-col.relative(:xs="24" :sm="8" :md="8" :lg="8" :xl="8" style="padding-top: 10px; padding-bottom: 10px;")
        slogan-item(:title="`ĐẶT HÀNG`" :description="`${apply.start} - ${apply.end}`")
      el-col.relative(:xs="24" :sm="8" :md="8" :lg="8" :xl="8" v-for="item in slogans" :key="item.title" style="padding-top: 10px; padding-bottom: 10px;")
        slogan-item(:title="item.title" :description="item.description")
</template>

<script>
  import SloganItem from './SloganItem'
  import './slogan.scss'
  import background from '~/assets/products/dh.png'
  export default {
    components: {
      SloganItem
    },
    props: {
      slogans: {
        type: Array,
        default: () => [
          {
            title: 'GIAO HÀNG',
            description:'NHANH CHÓNG'
          },
          {
            title: 'ĐỔI TRẢ',
            description:'DỄ DÀNG'
          }
        ]
      }
    },
    computed: {
      apply () {
        return this.$store.getters.settings && this.$store.getters.settings.apply || {start: '08:00', end: '17:00'}
      }
    },
    data () {
      return {
        background
      }
    },
    name: 'Slogan'
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div.slogan__container
    el-row(:gutter="50")
      el-col.relative(:span="8" v-for="item in slogans" :key="item.title")
        slogan-item(:title="item.title" :description="item.description")
</template>

<script>
  import SloganItem from './SloganItem'
  import './slogan.scss'
  export default {
    components: {
      SloganItem
    },
    props: {
      slogans: {
        type: Array,
        default: () => [
          {
            title: 'ĐẶT HÀNG',
            description:'02:00 AM - 09:00 AM'
          },
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
    name: 'Slogan'
  }
</script>

<style scoped>

</style>
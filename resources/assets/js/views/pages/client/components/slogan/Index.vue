<template lang="pug">
  div.slogan__container
    el-row(:gutter="50")
      el-col.relative(:span="8" v-for="item in 3" :key="item")
        slogan-item
</template>

<script>
  import SloganItem from './SloganItem'
  import './slogan.scss'
  export default {
    components: {
      SloganItem
    },
    name: 'Slogan'
  }
</script>

<style scoped>

</style>
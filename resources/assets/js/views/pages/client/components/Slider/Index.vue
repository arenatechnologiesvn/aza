<template lang="pug">
  el-carousel(:interval="4000" height="500px" type="card")
    el-carousel-item(v-for="item in 3" :key="item")
</template>

<script>
  import './slider.scss'
  export default {
    name: 'HomeSlider'
  }
</script>
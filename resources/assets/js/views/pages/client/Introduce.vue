<template lang="pug">
  div.container
    bread-crumb
    div.grid-content(style="background-color: white; margin: 10px 0 20px; padding: 10px 15px;")
      h4 Content
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  export default {
    name: 'Introduce',
    components: {
      BreadCrumb
    }
  }
</script>

<style scoped>

</style>
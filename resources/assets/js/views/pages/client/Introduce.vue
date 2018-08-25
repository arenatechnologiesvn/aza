<template lang="pug">
  div.container
    bread-crumb
    div.grid-content(style="background-color: white; margin: 10px 0 20px; padding: 10px 15px;")
      div(v-html="introduce")
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  export default {
    name: 'Introduce',
    computed: {
      introduce () {
        return this.$store.getters && this.$store.getters.settings.introduce && this.$store.getters.settings.introduce.content
      }
    },
    components: {
      BreadCrumb
    }
  }
</script>

<style scoped>

</style>
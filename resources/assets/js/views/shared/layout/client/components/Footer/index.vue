<template lang="pug">
  div.footer

    footer-info.container()
    div.line
    copyright.container
</template>

<script>
  import Copyright from './Social'
  import FooterInfo from './FooterInfo'
  import './footer.scss'
  import { mapGetters } from 'vuex'
  export default {
    name: 'Footer',
    components: {
      Copyright,
      FooterInfo
    },
    computed: {
      ...mapGetters(['settings'])
    },
    methods: {
      company () {
        return this.settings && this.settings.company
      }
    }
  }
</script>

<style scoped>

</style>
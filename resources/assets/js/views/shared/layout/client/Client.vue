<template lang="pug">
  div
    div.navbar__container
      navbar
    div(style="padding-top: 120px;")
      app-main
    div.footer__container
      asa-footer
    popup
</template>

<script>
  import AppMain from '~/views/shared/components/AppMain'
  import Navbar from './components/Navbar'
  import AsaFooter from './components/Footer'
  import {mapActions} from 'vuex'
  import '~/style/client.scss'
  import Popup from './components/Popup'
  export default {
    name: 'ClientLayout',
    components: {
      AppMain,
      Navbar,
      AsaFooter,
      Popup
    },
    watch: {
      $route: 'fetchData'
    },
    methods: {
      ...mapActions('products', {
        fetchProducts: 'fetchList'
      }),
      ...mapActions('favorite', {
        fetchFavorites: 'fetchList'
      }),
      fetchData () {
        this.fetchProducts();
      }
    },
    created (){
      this.fetchData()
      this.fetchFavorites()
    }
  }
</script>
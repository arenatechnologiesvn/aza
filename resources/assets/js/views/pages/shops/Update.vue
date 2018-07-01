<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid store-alt")
        span(style="margin-left: 10px;") CẬP NHẬT CỬA HÀNG {{current && current.name}}
      span(style="float: right")
        svg-icon(icon-class="fa-solid ")
    div.card-content
      aza-form(:shop="current" :is-update="true")
</template>

<script>
  import { mapActions, mapGetters, mapState} from 'vuex'
  import AzaForm from './components/Form'
  import BaseMixin from '../mixin'
  export default {
    name: 'ShopUpdate',
    mixins: [BaseMixin],
    components: {
      AzaForm
    },
    computed: {
      ...mapGetters('shops', {
        ById : 'byId',
        isLoading: 'isLoading'
      }),
      ...mapState([
        'route', // vuex-router-sync
      ]),
      current () {
        return this.ById(this.$route.params.id);
      }
    },
    methods: {
      ...mapActions('shops', {
        fetchUpdate: 'fetchSingle'
      }),
      fetchData () {
        return this.fetchUpdate({
          id: this.$route.params.id
        }).catch(() => this.$router.push({name: 'page404'}))
      }
    },
    watch: {
      $route: 'fetchData'
    },
    created () {
      this.fetchData()
      this.loading()
    }
  }
</script>
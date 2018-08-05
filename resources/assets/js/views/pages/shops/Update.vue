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
      ])
    },
    data() {
      return {
        current: {
          name: '',
          customer_id: null,
          phone: '',
          address: '',
          zone: '',
          province_code: '',
          district_code: '',
          ward_code: '',
          description: ''
        }
      }
    },
    methods: {
      ...mapActions('shops', {
        fetchUpdate: 'fetchSingle'
      }),
      fetchData () {
        return this.fetchUpdate({
          id: this.$route.params.id
        }).then(() => {
          this.current = JSON.parse(JSON.stringify(this.ById(this.route.params.id)));
          this.current.customer_id = parseInt(this.current.customer_id)
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
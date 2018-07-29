<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") CẬP NHẬT KHÁCH HÀNG - {{current && current.code}}
      span(style="float: right")
        svg-icon(icon-class="fa-solid ")
    div.card-content
      aza-form(:customer="current" :is-update="true")
</template>

<script>
  import { mapActions, mapGetters, mapState} from 'vuex'
  import AzaForm from './components/Form'
  import BaseMixin from '../mixin'
  export default {
    name: 'EmployeeUpdate',
    mixins: [BaseMixin],
    components: {
      AzaForm
    },
    computed: {
      ...mapGetters('customers', {
        ById : 'byId',
        isLoading: 'isLoading'
      }),
      ...mapState([
        'route', // vuex-router-sync
      ]),
      current () {
        let customer  = this.ById(this.$route.params.id);
        let tmpCustomer = {};
        if(customer) {
          tmpCustomer.code = customer.code
          tmpCustomer.customer_type = customer.customer_type
          tmpCustomer.address = customer.address
          tmpCustomer.first_name = customer.user.first_name
          tmpCustomer.last_name = customer.user.last_name,
          tmpCustomer.phone = customer.user.phone
          tmpCustomer.employee_id = customer.employee.id
          tmpCustomer.is_active = customer.user.is_active > 0
          tmpCustomer.name = customer.user.name
        }
        return tmpCustomer
      }
    },
    methods: {
      ...mapActions('customers', {
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
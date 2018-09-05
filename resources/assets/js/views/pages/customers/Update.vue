<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") HỒ SƠ KHÁCH HÀNG - {{current && current.code}}
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
        ById : 'byId'
      }),
      ...mapState([
        'route', // vuex-router-sync
      ])
    },
    data() {
      return {
        current: {
          code: '',
          customer_type: 0,
          employee_id: null,
          zone: '',
          province_code: '',
          district_code: '',
          ward_code: '',
          shops: [],
          user: {
            avatar: [],
            email: '',
            name: '',
            first_name: '',
            last_name: '',
            phone: '',
            address: '',
            is_active: false
          }
        }
      }
    },
    methods: {
      ...mapActions('customers', {
        fetchUpdate: 'fetchSingle'
      }),
      fetchData () {
        return this.fetchUpdate({
          id: this.$route.params.id
        }).then(() => {
          this.current = JSON.parse(JSON.stringify(this.ById(this.$route.params.id)));
          this.current.employee_id = this.current.employee_id ? parseInt(this.current.employee_id) : ''
          this.current.customer_type = this.current.customer_type ? parseInt(this.current.customer_type) : ''
        }).catch(() => {
          this.$notify({ title: 'Thông báo', message: 'Tải về hồ sơ nhân viên thất bại', type: 'error' });
          this.$router.push({ name: 'customer_index', replace: true });
        })
      }
    },
    watch: {
      $route: 'fetchData'
    },
    created () {
      this.fetchData()
    }
  }
</script>
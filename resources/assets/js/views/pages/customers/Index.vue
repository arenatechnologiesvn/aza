<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách khách hàng
    div.search__wrapper(style="margin: 10px 0 20px")
      customer-form-search
    div.control__wraper
      employee-control(@on-add="handAddClick")
    div.index__wrapper
      employee-table(:customers="customers" :total="total" @on-update="handUpdateClick")
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import EmployeeControl from './components/Control'
  import EmployeeTable from './components/Table'
  import CustomerFormSearch from './components/FormSearch'
  export default {
    name: 'EmployeeIndex',
    components: {
      EmployeeControl,
      EmployeeTable,
      CustomerFormSearch
    },
    computed: {
      ...mapGetters('customer', {
        customers: 'list'
      }),
      total () {
        return this.customers.length
      }
    },
    watch: {
      $route : 'getList'
    },
    methods: {
      ...mapActions('customer', {
        'getList': 'getList'
      }),
      handAddClick () {
        this.$router.push({
          name: 'customer_create'
        })
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'customer_update',
          params: {
            id
          }
        })
      }
    },
    created () {
      this.getList()
    }
  }
</script>

<style scoped>

</style>
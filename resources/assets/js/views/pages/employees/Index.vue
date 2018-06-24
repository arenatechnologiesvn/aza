<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách nhân viên
    div.search__wrapper(style="margin: 10px 0 20px")
      employee-form-search(@on-search="onSearch")
    div.control__wraper
      employee-control(@on-add="handAddClick")
    div.index__wrapper
      employee-table(ref="table" :employees="employees" :total="total" @on-update="handUpdateClick")
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import EmployeeControl from './components/Control'
  import EmployeeTable from './components/Table'
  import EmployeeFormSearch from './components/FormSearch'

  export default {
    name: 'EmployeeIndex',
    components: {
      EmployeeControl,
      EmployeeTable,
      EmployeeFormSearch
    },
    computed: {
      ...mapGetters('employee', {
        employees: 'list'
      }),
      total() {
        return this.employees.length
      }
    },
    watch: {
      $route : 'getList'
    },
    methods: {
      ...mapActions('employee', {
        'getList': 'getList'
      }),
      handAddClick () {
        this.$router.push({
          name: 'employee_create'
        })
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'employee_update',
          params: {
            id
          }
        })
      },
      onSearch (value) {
        this.$refs.table.$emit('filter-change', {name: value})
      }
    },
    created () {
      this.getList()
    }
  }
</script>

<style scoped>

</style>
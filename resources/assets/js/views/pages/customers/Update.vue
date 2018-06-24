<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Cập nhật khách hàng
      span(style="float: right")
        svg-icon(icon-class="fa-solid ")
    div.card-content
      employee-form(:employee="currentEmployee" :is-update="true")
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import EmployeeForm from './components/Form'

  export default {
    name: 'EmployeeUpdate',
    components: {
      EmployeeForm
    },
    computed: {
      ...mapGetters('employee', {
        employeeById : 'byId'
      }),
      currentEmployee () {
        return this.employeeById(this.$route.params.id);
      }
    },
    methods: {
      ...mapActions('employee', {
        'getById': 'getById'
      }),
      getByIdRoute () {
        const id = this.$route.params.id
        this.getById(id)
      },
    },
    watch: {
      $route: 'getByIdRoute'
    },
    created () {
      this.getByIdRoute()
    }
  }
</script>

<style scoped>

</style>
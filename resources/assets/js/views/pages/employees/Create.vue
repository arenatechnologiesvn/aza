<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid user")
        span(style="margin-left: 10px;") Thêm mới nhân viên
      span(style="float: right")
        svg-icon(icon-class="fa-solid arrow-alt-left")
    div.card-content
      employee-form
</template>

<script>
  import EmployeeForm from './components/Form'
  export default {
    name: 'CreateEmployee',
    components: {
      EmployeeForm
    }
  }
</script>

<style scoped>

</style>
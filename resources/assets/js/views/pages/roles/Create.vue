<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid plus")
        span(style="margin-left: 10px;") Thêm mới quyền
      span(style="float: right")
        svg-icon(icon-class="fa-solid arrow-alt-left")
    div.card-content
      role-form
</template>

<script>
  import RoleForm from './components/Form'
  export default {
    name: 'RoleCreate',
    components: {
      RoleForm
    }
  }
</script>

<style scoped>

</style>
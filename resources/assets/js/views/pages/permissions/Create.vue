<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid user-plus")
        span(style="margin-left: 10px;") THÊM MỚI NHÂN VIÊN
      span(style="float: right")
        svg-icon(icon-class="fa-solid arrow-alt-left")
    div.card-content
      form-permission
</template>

<script>
  import FormPermission from './components/Form'
  export default {
    name: 'CreatePermission',
    components: {
      FormPermission
    }
  }
</script>

<style scoped>

</style>
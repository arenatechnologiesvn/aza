<template lang="pug">
  div.control
    el-row
      el-col(:span="12")
        h4.control__info(style="margin: 0;") Đã chọn {{selected}} nhân viên
      el-col(:span="12" style="text-align: right;")
        el-button(type="success" size="small")
          svg-icon(icon-class="fa-solid file-excel")
          span.ml-5 Xuất Excel
        el-button(type="primary" size="small" @click="handleAdd")
          svg-icon(icon-class="fa-solid plus")
          span.ml-5 Thêm mới
</template>

<script>
  export default {
    name: 'EmployeeControl',
    props: {
      selected: {
        type: Number,
        default: 0
      }
    },
    methods: {
      handleAdd () {
        this.$emit('on-add')
      }
    }
  }
</script>

<style scoped>

</style>
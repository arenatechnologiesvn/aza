<template lang="pug">
  div.control
    el-row
      el-col(:span="12")
        el-dropdown(split-button size="small") Đã chọn {{selected}} nhân viên
          el-dropdown-menu(slot="dropdown")
            el-dropdown-item
              svg-icon(icon-class="fa-solid unlock-alt")
              span Kich hoạt
            el-dropdown-item
              svg-icon(icon-class="fa-solid user-lock")
              span Khóa tài khoản
            el-dropdown-item
              svg-icon(icon-class="fa-solid trash-alt")
              sapn Xóa
        h4.control__info(style="margin: 0;")
      el-col(:span="12" style="text-align: right;")
        el-button(type="success" size="small")
          svg-icon(icon-class="fa-solid file-excel")
          span.ml-5 Xuất Excel
        el-button(type="primary" size="small" @click="handleAdd")
          svg-icon(icon-class="fa-solid plus-circle")
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
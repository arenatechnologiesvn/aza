<template lang="pug">
  div.control
    el-row
      el-col(:span="12")
        el-dropdown(split-button size="small") Đã chọn {{selected}} cửa hàng
          el-dropdown-menu(slot="dropdown")
            el-dropdown-item
              svg-icon(icon-class="fa-solid trash-alt")
              span Xóa
        h4.control__info(style="margin: 0;")
      el-col(:span="12" style="text-align: right;")
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
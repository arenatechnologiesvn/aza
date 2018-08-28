<template lang="pug">
  div.control
    el-row
      //- el-col(:span="12")
        //- el-dropdown(split-button size="small" trigger="click") Đã chọn {{selected}} khách hàng
        //-   el-dropdown-menu(slot="dropdown")
        //-     el-dropdown-item
        //-       svg-icon(icon-class="fa-solid unlock-alt")
        //-       span Kich hoạt
        //-     el-dropdown-item
        //-       svg-icon(icon-class="fa-solid user-lock")
        //-       span Khóa tài khoản
        //-     el-dropdown-item
        //-       svg-icon(icon-class="fa-solid trash-alt")
        //-       span Xóa
        h4.control__info(style="margin: 0;")
      el-col(:span="24" style="text-align: right;")
        el-button(type="success" size="small" @click="handleImport")
          svg-icon(icon-class="fa-solid upload")
          span.ml-5  Tải lên
        el-button(type="primary" size="small" @click="handleAdd")
          svg-icon(icon-class="fa-solid plus")
          span.ml-5 Thêm mới
</template>

<script>
  export default {
    name: 'CustomerControl',
    props: {
      selected: {
        type: Number,
        default: 0
      }
    },
    methods: {
      handleAdd () {
        this.$emit('on-add')
      },

      handleImport() {
        this.$emit('on-import')
      },
    }
  }
</script>

<style scoped>

</style>
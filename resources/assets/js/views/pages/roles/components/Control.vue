<template lang="pug">
  div.control
    el-row
      el-col(:span="12")
        h4.control__info(style="margin: 0;") Đã chọn {{selected}} quyền
      el-col(:span="12" style="text-align: right;")
        el-button(type="primary" size="small" @click="handleAdd")
          svg-icon(icon-class="fa-solid plus")
          span.ml-5 Thêm mới
</template>

<script>
  export default {
    name: 'RoleControl',
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
<template lang="pug">
  div.control
    el-row
      el-col(:span="24" style="text-align: right;")
        el-button(type="primary" size="small" @click="handleAdd")
          svg-icon(icon-class="fa-solid plus-circle")
          span.ml-5 Thêm mới
</template>

<script>
  export default {
    name: 'PermissionControl',
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
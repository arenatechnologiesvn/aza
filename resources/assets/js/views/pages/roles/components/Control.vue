<template lang="pug">
  div.control
    el-row
      el-col(:span="12")
        h4.control__info(style="margin: 0;")
          el-button(v-show="selection.length>0" type="danger" size="small" @click="onDeleteSelect")
            svg-icon(icon-class="fa-solid trash")
            span(style="margin-left: 7px") Xóa {{selection.length}} quyền đã chọn
      el-col(:span="12" style="text-align: right; float: right")
        el-button(type="primary" size="small" @click="handleAdd")
          svg-icon(icon-class="fa-solid plus-circle")
          span(style="margin-left: 7px") Thêm mới
</template>

<script>
  import { mapActions } from 'vuex'
  export default {
    name: 'RoleControl',
    props: {
      selection: {}
    },
    methods: {
      ...mapActions('roles', {
        deleteSelection: 'deleteSelection'
      }),
      handleAdd () {
        this.$emit('on-add')
      },
      onDeleteSelect () {
        const ids = this.selection.map(item => item.id)
        this.deleteSelection(ids)
      }
    }
  }
</script>

<style scoped>

</style>
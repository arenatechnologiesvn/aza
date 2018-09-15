<template lang="pug">
  div.control
    el-row
      el-col(:span="24" style="text-align: right;")
        el-button(type="primary" size="small" @click="handleAdd" v-if="addEnable")
          svg-icon(icon-class="fa-solid plus-circle")
          span.ml-5 Thêm mới
</template>

<script>
  import {checkPermission} from '~/utils/util'
  import {ADD_ACTION} from '~/utils/const'
  export default {
    name: 'PermissionControl',
    props: {
      selected: {
        type: Number,
        default: 0
      }
    },
    computed: {
      addEnable () {
        return checkPermission(ADD_ACTION, this.$store.getters.mpermissions)
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
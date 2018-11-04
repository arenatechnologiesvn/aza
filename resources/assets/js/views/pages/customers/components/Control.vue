<template lang="pug">
  div.control
    el-row
      el-col(:span="8")
        el-dropdown(split-button :type="selected.length ? 'primary' : 'default'" size="small")
          span Đã chọn {{ selected.length }} khách hàng
          el-dropdown-menu(slot="dropdown")
            el-dropdown-item(style="color: #f56c6c" :disabled="selected.length === 0")
              span(@click="handleBulkDelete")
                svg-icon(icon-class="fa-solid trash")
                span.ml-5  Xóa
      el-col(:span="16" style="text-align: right;")
        el-button(type="success" size="small" @click="handleImport" v-if="uploadEnable")
          svg-icon(icon-class="fa-solid upload")
          span.ml-5  Tải lên
        el-button(type="primary" size="small" @click="handleAdd" v-if="addEnable")
          svg-icon(icon-class="fa-solid plus")
          span.ml-5 Thêm mới
</template>

<script>
  import {checkPermission} from '~/utils/util'
  import {ADD_CUSTOMER, UPLOAD_CUSTOMER} from '~/utils/const'

  export default {
    name: 'CustomerControl',
    props: {
      selected: {
        type: Array,
        default: () => {
          return [];
        }
      }
    },
    computed: {
      addEnable () {
        return checkPermission(ADD_CUSTOMER, this.$store.getters.mpermissions)
      },
      uploadEnable () {
        return checkPermission(UPLOAD_CUSTOMER, this.$store.getters.mpermissions)
      }
    },
    methods: {
      handleAdd () {
        this.$emit('on-add')
      },

      handleImport() {
        this.$emit('on-import')
      },

      handleBulkDelete() {
        this.$emit('on-bulk-delete')
      }
    }
  }
</script>

<style scoped>

</style>
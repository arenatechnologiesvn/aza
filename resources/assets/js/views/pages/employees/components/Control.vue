<template lang="pug">
  div.control
    el-row
      //- el-col(:span="12")
      //-   el-dropdown(split-button size="small") Đã chọn {{selected}} nhân viên
      //-     el-dropdown-menu(slot="dropdown")
      //-       el-dropdown-item
      //-         svg-icon(icon-class="fa-solid unlock-alt")
      //-         span Kich hoạt
      //-       el-dropdown-item
      //-         svg-icon(icon-class="fa-solid user-lock")
      //-         span Khóa tài khoản
      //-       el-dropdown-item
      //-         svg-icon(icon-class="fa-solid trash-alt")
      //-         span Xóa
      //-   h4.control__info(style="margin: 0;")
      el-col(:span="24" style="text-align: right;")
        //- el-button(type="success" size="small" @click="redirectToImportPage")
        //-   svg-icon(icon-class="fa-solid upload")
        //-   span.ml-5  Tải lên
        el-button(type="primary" size="small" @click="handleAdd" v-if="addEnable")
          svg-icon(icon-class="fa-solid plus-circle")
          span.ml-5 Thêm mới
</template>

<script>
  import {checkPermission} from '~/utils/util'
  import {ADD_EMPLOYEE} from '~/utils/const'

  export default {
    name: 'EmployeeControl',
    props: {
      selected: {
        type: Number,
        default: 0
      }
    },
    computed: {
      addEnable () {
        return checkPermission(ADD_EMPLOYEE, this.$store.getters.mpermissions)
      }
    },
    methods: {
      handleAdd () {
        this.$emit('on-add')
      },

      redirectToImportPage() {
        this.$router.push({ name: 'employee_import' });
      },
    }
  }
</script>

<style scoped>

</style>
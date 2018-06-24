<template lang="pug">
  div.form-search__wrapper
    el-form.search
      el-row(style="margin: 0 -10px;")
        el-col(:span="12")
          el-form-item
            el-input(placeholder="Tìm kiếm" v-model="search.key" suffix-icon="el-icon-search" style="width: 100%")
        el-col(:span="4")
          el-form-item
            el-select(placeholder="Nhân viên" v-model="search.employee_id" )
              el-option(v-for="item in employeeList" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="4")
          el-form-item
            el-select(placeholder="Loại khách hàng" v-model="search.customer_type")
              el-option(label="VIP" value="1")
              el-option(label="THƯỜNG" value="2")
        el-col(:span="4")
          el-form-item
            el-select(placeholder="Trạng thái" v-model="search.status")
              el-option(label="Chưa kích hoạt" value="1")
              el-option(label="Đang hoạt động" value="2")
              el-option(label="Đang bị khóa" value="3")
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    name: 'CustomerFormSearch',
    computed: {
      ...mapGetters('employee', {
        'employees' : 'list'
      }),
      employeeList () {
        return this.employees.map(item => {
          return {
            id: item.id,
            name: item.name
          }
        })
      }
    },
    data () {
      return {
        search: {
          key: '',
          status: '',
          role_id: ''
        }
      }
    }
  }
</script>

<style scoped>

</style>
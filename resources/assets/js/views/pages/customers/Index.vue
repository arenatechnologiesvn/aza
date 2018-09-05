<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH KHÁCH HÀNG
    div.search__wrapper(style="margin: 10px 0 20px")
      div.form-search__wrapper
        el-form.search(size="small")
          el-row(style="margin: 0 -10px;")
            el-col(:span="12")
              el-form-item(label="Tìm kiếm:")
                el-input(placeholder="Tìm kiếm" v-model="key" clearable suffix-icon="el-icon-search" style="width: 100%")
            el-col(:span="4")
              el-form-item(label="Nhân viên:")
                el-select(placeholder="Nhân viên" v-model="employee_id" clearable filterable style="width: 100%")
                  el-option(v-for="item in employeeList" :key="item.id" :label="item.value" :value="item.id")
            el-col(:span="4")
              el-form-item(label="Loại KH:")
                el-select(placeholder="Loại khách hàng" v-model="customer_type" clearable filterable style="width: 100%")
                  el-option(label="VIP" :value="1")
                  el-option(label="Thường" :value="0")
            el-col(:span="4")
              el-form-item(label="Trạng thái:")
                el-select(placeholder="Trạng thái" v-model="status" clearable filterable style="width: 100%")
                  el-option(label="Đang hoạt động" :value="0")
                  el-option(label="Đang tạm khóa" :value="1")
                  el-option(label="Chưa kích hoạt" :value="2")
    div.control__wrapper
      aza-control(@on-add="handAddClick" @on-import="handImportClick")
    div.index__wrapper
      aza-table(:customers="current" :total="total" @on-update="handUpdateClick" @on-change-active="changeActiveHandle" @on-delete="deleteHandle")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import BaseMixin from '../mixin'

  export default {
    name: 'CustomerIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl
    },
    data () {
      return {
        key: '',
        employee_id: null,
        customer_type: null,
        status: null
      }
    },
    computed: {
      ...mapGetters('customers', {
        customers: 'list',
        isLoading: 'isLoading'
      }),
      ...mapGetters('employees', {
        employees: 'list'
      }),
      employeeList () {
        return this.employees.filter(item =>  parseInt(item.user.role_id) === 3).map(item => {
          return {
            id: item.id,
            value: item.user.full_name
          }
        })
      },
      current () {
        return this.customers && this.customers.map(item => Object.assign(
          item,
          Object.assign(item.user, {
            is_active: item.user.is_active,
            is_verified: item.user.is_verified
          }),
          { id: item.id, customer_type: item.customer_type })
        ).filter(item => item.code.indexOf(this.key) > -1 || item.user.full_name.indexOf(this.key) > -1
        ).filter(item => {
          if(this.employee_id === null || this.employee_id.toString().trim() === '') return true;
          return item.employee && this.employee_id.toString().trim() === item.employee.id.toString().trim()
        }).filter(item => {
          if (this.customer_type === null || this.customer_type.toString().trim() === '') return true;
          return this.customer_type.toString().trim() === item.customer_type.toString().trim()
        }).filter(item => {
          if (this.status === null || this.status.toString().trim() === '') return true;
          if (this.status.toString().trim() === '0') return item.user.is_active
          if (this.status.toString().trim() === '1') return item.user.is_verified && !item.user.is_active
          return !item.user.is_verified
        });
      },
      total () {
        this.current.length
      },
      ...mapState([
        'route'
      ])
    },
    watch: {
      $route : 'fetchData',
      search: {
        handler(){
          this.fetchFind()
        },
        deep: true
      }
    },
    methods: {
      ...mapActions('customers', {
        fetchCustomers: 'fetchList',
        fetchSearch: 'search',
        deleteSelection: 'deleteSelection',
        destroy: 'destroy'
      }),
      ...mapActions('employees', {
        fetchEmployees: 'fetchList'
      }),
      ...mapActions({
        updateUserActive: 'user/Update'
      }),
      changeActiveHandle (user_id, params) {
        this.updateUserActive({
          id: user_id,
          params: { is_active: params.is_active }
        }).then(() => {
          this.$message({ type: 'success', message: 'Cập nhật thành công' });
        }).catch(() => {
          this.$message({ type: 'error', message: 'Cập nhật thất bại' });
        });
      },
      fetchFind () {
        this.fetchSearch(this.search)
      },
      fetchData() {
        return this.fetchCustomers()
      },
      handAddClick () {
        this.$router.push({
          name: 'customer_create'
        })
      },
      handImportClick () {
        this.$router.push({
          name: 'customer_import'
        })
      },
      deleteHandle (id) {
        this.$confirm('Bạn muốn xóa khách hàng này?', 'Xác nhận xóa khách hàng', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy bỏ',
          type: 'warning',
          confirmButtonClass: 'el-button el-button--danger'
        }).then(() => {
          this.destroy({ id }).then(() => {
            this.$message({
              type: 'success',
              message: 'Xóa thành công'
            })
          }).catch(() => {
            this.$message({
              type: 'error',
              message: `Xóa thất bại`
            })
          })
        }).catch(() => {
          // Do nothing
        });
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'customer_update',
          params: {
            id
          }
        })
      },
      onSelected (selection) {
        this.selection = selection
      },
      onChangeRole () {
        this.current.filter(item => item.role_id === this.search.role_id)
      },
      onDeleteSelect (ids) {
        this.confirm(() => {
          this.deleteSelection({
            customUrl: 'deletes',
            data: {data: ids}
          }).then(() => {
            this.$message({
              type: 'success',
              message: `Xóa thành công`
            })
          })
        }, () => {
          this.$message({
            type: 'info',
            message: `Huy xóa khách hàng`
          })
        })
      }
    },
    created () {
      this.loading()
      this.fetchData()
      this.fetchEmployees()
    }
  }
</script>
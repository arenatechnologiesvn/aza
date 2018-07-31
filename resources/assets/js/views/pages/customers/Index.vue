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
              el-form-item
                el-input(placeholder="Tìm kiếm" v-model="key" suffix-icon="el-icon-search" style="width: 100%")
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Nhân viên" v-model="employee_id" clearable filterable )
                  el-option(v-for="item in employeeList" :key="item.id" :label="item.value" :value="item.id")
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Loại khách hàng" v-model="customer_type" clearable filterable)
                  el-option(label="VIP" :value="1")
                  el-option(label="THƯỜNG" :value="0")
                  el-option(label="TẤT CẢ" :value="-1")
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Trạng thái" v-model="is_active" clearable filterable)
                  el-option(label="Đang hoạt động" :value="1")
                  el-option(label="Đang bị khóa" :value="0")
                  el-option(label="Tất cả" :value="-1")
    div.control__wrapper
      aza-control(@on-add="handAddClick")
    div.index__wrapper
      aza-table(:customers="current" :total="total" @on-update="handUpdateClick")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import AzaSearch from './components/FormSearch'
  import BaseMixin from '../mixin'

  export default {
    name: 'CustomerIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl,
      AzaSearch
    },
    data () {
      return {
        key: '',
        employee_id: null,
        customer_type: null,
        is_active: null
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
        return this.employees.filter(item => item.user.role_id == 3).map(item => {
          return {
            id: item.id,
            value: item.user.full_name
          }
        })
      },
      current () {
        return this.customers && this.customers
          .filter(item => item.code.indexOf(this.key) > -1
            || item.user.full_name.indexOf(this.key) > -1
          ).filter(item => {
            if(this.employee_id === null || this.employee_id === '' || this.employee_id === -1) return true;
            return this.employee_id === item.employee.id
          }).filter(item => {
            if(this.customer_type === null || this.customer_type === '' || this.customer_type === -1) return true;
            return this.customer_type === item.customer_type
          }).filter(item => {
            if(this.is_active === null || this.is_active === '' || this.is_active === -1) return true;
            return this.is_active === item.user.is_active
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
        updateRole: 'update',
        destroy: 'destroy'
      }),
      ...mapActions('employees', {
        fetchEmployees: 'fetchList'
      }),
      changeStatusHandle (id, data) {
        this.updateRole({
          id: id,
          data: data
        })
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
      deleteHandle (id) {
        this.$confirm('Bạn muốn xóa khách hàng này?', 'Xác nhận xóa khách hàng', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy bỏ',
          type: 'warning',
          confirmButtonClass: 'el-button el-button--danger'
        }).then(() => {
          this.destroy(id).then(() => {
            this.$message({
              type: 'success',
              message: `Xóa thành công khách hàng - ${id}`
            })
          })
        }).catch(() => {
          this.$message({
            type: 'error',
            message: 'Hủy xóa thành công'
          });
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
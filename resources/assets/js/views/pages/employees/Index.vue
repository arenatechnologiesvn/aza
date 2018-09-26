<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH NHÂN VIÊN
    div.search__wrapper(style="margin: 10px 0 20px")
      div.form-search__wrapper
        el-form.search(v-model="search" size="small")
          el-row(:gutter="5" style="margin: 0 -10px;")
            el-col(:span="16")
              el-form-item(label="Tìm kiếm:")
                el-input(placeholder="Tìm kiếm" v-model="key" suffix-icon="el-icon-search" style="width: 100%" clearable)
            el-col(:span="4")
              el-form-item(label="Vai trò:")
                el-select(placeholder="Vai trò" v-model="role_id" @change="onChangeRole" clearable filterable style="width: 100%")
                  el-option(v-for="item in roleList" :key="item.id" :label="item.value" :value="item.id")
                  el-option(label="Tất cả" :value="-1")
            el-col(:span="4")
              el-form-item(label="Trạng thái:")
                el-select(placeholder="Trạng thái" v-model="status" clearable filterable style="width: 100%")
                  el-option(label="Đang hoạt động" :value="0")
                  el-option(label="Đang tạm khóa" :value="1")
                  el-option(label="Chưa kích hoạt" :value="2")
    div.control__wrapper
      aza-control(@on-add="handAddClick")
    div.index__wrapper
      aza-table(ref="table" @on-delete="deleteHandle" :employees="current" :total="total" @on-update="handUpdateClick" @on-change-active="changeActiveHandle")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import BaseMixin from '../mixin'

  export default {
    name: 'EmployeeIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl
    },
    data () {
      return {
        key: '',
        role_id: null,
        status: null
      }
    },
    computed: {
      ...mapGetters('employees', {
        employees: 'list',
        isLoading: 'isLoading'
      }),
      ...mapGetters('roles', {
        roles: 'list'
      }),
      roleList () {
        return this.roles.filter(item => item.is_employee).map(item => {
          return {
            id: item.id,
            value: item.description
          }
        })
      },
      current () {
        return this.employees.map(item => Object.assign(item, { is_verified: item.is_verified, is_active: item.is_active }))
          .filter(item => item.code.indexOf(this.key) > -1
            || item.user.email.indexOf(this.key) > -1
            || item.user.full_name.indexOf(this.key) > -1)
          .filter(item => {
            if(this.role_id === null || this.role_id.toString().trim() === '' || this.role_id === -1) return true;
            return (this.role_id.toString().trim() === item.user.role_id.toString().trim());
          }).filter(item => {
            if (this.status === null || this.status.toString().trim() === '') return true;
            if (this.status.toString().trim() === '0') return item.user.is_active
            if (this.status.toString().trim() === '1') return item.user.is_verified && !item.user.is_active
            return !item.user.is_verified
          })
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
      ...mapActions('employees', {
        fetchEmployees: 'fetchList',
        fetchSearch: 'search',
        deleteSelection: 'deleteSelection',
        destroy: 'destroy'
      }),
      ...mapActions('roles', {
        fetchRoles: 'fetchList'
      }),
      ...mapActions({
        updateUserActive: 'user/UpdateIsActive'
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
        return this.fetchEmployees()
      },
      handAddClick () {
        this.$router.push({
          name: 'employee_create'
        })
      },
      deleteHandle (id) {
        this.$confirm('Bạn muốn xóa nhân viên này?', 'Xác nhận xóa', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy bỏ',
          type: 'warning',
          confirmButtonClass: 'el-button el-button--danger'
        }).then(() => {
          this.destroy(id).then(() => {
            this.$message({
              type: 'success',
              message: 'Xóa thành công'
            })
          }).catch(() => {
            this.$message({
              type: 'error',
              message: 'Xóa thất bại'
            })
          });
        }).catch(() => {
          // Do nothing
        });
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'employee_update',
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
              message: `Delete completed`
            })
          })
        }, () => {
          this.$message({
            type: 'info',
            message: `Cancel Delete`
          })
        })
      }
    },
    created () {
      this.loading()
      this.fetchData()
      this.fetchRoles()
    }
  }
</script>
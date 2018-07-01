<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH NHÂN VIÊN
    div.search__wrapper(style="margin: 10px 0 20px")
      div.form-search__wrapper
        el-form.search(v-model="search" size="small")
          el-row(style="margin: 0 -10px;")
            el-col(:span="16")
              el-form-item
                el-input(placeholder="Tìm kiếm" v-model="search.key" suffix-icon="el-icon-search" style="width: 100%" clearable)
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Vai trò" v-model="search.role_id" @change="onChangeRole" clearable)
                  el-option(v-for="item in roleList" :key="item.id" :label="item.value" :value="item.id")
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Trạng thái" v-model="search.status" clearable)
                  el-option(label="Đang hoạt động" :value="true")
                  el-option(label="Đang bị khóa" :value="false")
    div.control__wrapper
      aza-control(@on-add="handAddClick")
    div.index__wrapper
      aza-table(ref="table" @on-delete="deleteHandle" :employees="current" :total="total" @on-update="handUpdateClick" @on-change-status="changeStatusHandle")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import AzaSearch from './components/FormSearch'
  import BaseMixin from '../mixin'

  export default {
    name: 'EmployeeIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl,
      AzaSearch
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
        return this.employees
          .filter(item => {
            for(let index in this.search) {
              if (index === 'key') {
                return item.full_name.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1 ||
                  item.name.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1
              } else if(typeof this.search[index] === 'string') {
                  return item[index].toLowerCase().indexOf(this.search[index].toLowerCase()) > -1
              } else {
                return item[index] === this.search[index];
              }
            }
          }
          );
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
        updateRole: 'update',
        destroy: 'destroy'
      }),
      ...mapActions('roles', {
        fetchRoles: 'fetchList'
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
              message: `Delete completed ${id}`
            })
          })
        }).catch(() => {
          this.$message({
            type: 'error',
            message: 'Delete canceled'
          });
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
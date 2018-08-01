<template lang="pug">
  div.index__container
    div.table {{load}}
      el-table(:data="permissions.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" v-loading="loading" border  style="width: 100%" size="small")
        el-table-column(prop="user.icon" width="30" style="text-align: center; margin: 0 auto;")
          template(slot-scope="scope")
            svg-icon(:icon-class="scope.row.icon || ''")
        el-table-column(prop="title" label="NỘI DUNG" sortable min-width="100")
        el-table-column(prop="name" label="ACTION" sortable width="200")
        el-table-column(label="ADMIN" width="70")
          template(slot-scope="scope")
            el-checkbox(v-model="admin[scope.row.id]" @change="change(1, 'admin')")
        el-table-column(label="QUẢN LÝ" width="100")
          template(slot-scope="scope")
            el-checkbox(v-model="manager[scope.row.id]" @change="change(5, 'manager')")
        el-table-column(label="NHÂN VIÊN SALE" width="150")
          template(slot-scope="scope")
            el-checkbox(v-model="sale[scope.row.id]" @change="change(3, 'sale')")
        el-table-column(label="NHÂN VIÊN OFFICE" width="150")
          template(slot-scope="scope")
            el-checkbox(v-model="officer[scope.row.id]" @change="change(4, 'officer')")
        el-table-column(label="KHÁCH HÀNG" width="100")
          template(slot-scope="scope")
            el-checkbox(v-model="customer[scope.row.id]" @change="change(2, 'customer')")
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[1, 5, 10, 20, 50, 100]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="permissions.length")

</template>

<script>
  import Vue from 'vue'
  import { mapActions, mapGetters } from 'vuex'
  export default {
    name: 'RolePermissionTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 100,
        admin: {},
        customer: {},
        manager: {},
        officer: {},
        sale: {}
      }
    },
    computed: {
      ...mapGetters('roles', {
        loading: 'isLoading'
      }),
      load () {
        this.permissions.map(item => {
          if(item.roles.filter(item => item.id === 1).length > 0) {
            Vue.set(this.admin, item.id, true)
          } else {
            Vue.set(this.admin, item.id, false)
          }
          if(item.roles.filter(item => item.id === 2).length > 0) {
            Vue.set(this.customer, item.id, true)
          } else {
            Vue.set(this.customer, item.id, false)
          }
          if(item.roles.filter(item => item.id === 5).length > 0) {
            Vue.set(this.manager, item.id, true)
          } else {
            Vue.set(this.manager, item.id, false)
          }
          if(item.roles.filter(item => item.id === 3).length > 0) {
            Vue.set(this.sale, item.id, true)
          } else {
            Vue.set(this.sale, item.id, false)
          }
          if(item.roles.filter(item => item.id === 4).length > 0) {
            Vue.set(this.officer, item.id, true)
          } else {
            Vue.set(this.officer, item.id, false)
          }
        })
      }
    },
    props: {
      permissions: {
        type: Array,
        default: () => []
      },
      total: {
        type: Number,
        default: 0
      }
    },
    methods: {
      ...mapActions('roles', {
        updateRole: 'update'
      }),
      change (id, name) {
        const permissions = Object.keys(this[name]).filter(item => this[name][item])
        this.updateRole({
          id,
          data:{
            permissions
          }
        }).then(() => this.$message({
          type: 'success',
          message: 'Cập nhật quyền thành công!'
        })).catch(err => this.$message({
          type: 'warning',
          message: 'Lỗi khi cập nhật quyền'
        }))
      },
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
      },
      handleEdit (id) {
        this.$emit('on-update', id)
      },
      onDelete (id) {
        this.$emit('on-delete', id)
      },
      onChangeStatus(id, status) {
        this.$emit('on-change-status', id, {
          status: !status
        })
      }
    }
  }
</script>
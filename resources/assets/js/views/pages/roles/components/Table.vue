<template lang="pug">
  div.index__container
    div.table
      el-table(:data="roles" border style="width: 100%" size="small" @selection-change="selectChange")
        el-table-column(type="selection" width="40")
        el-table-column(prop="title" label="TÊN QUYỀN" sortable)
        el-table-column(prop="description" label="MÔ TẢ" sortable width="180")
        el-table-column(prop="id" label="TÁC VỤ" width="120")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Chỉnh sửa" placement="top")
              el-button(size="mini" @click="handleEdit(scope.row.id)" round)
                svg-icon(icon-class="fa-solid user-edit")
            el-tooltip(effect="dark" content="Xóa" placement="top")
              el-button(size="mini" type="danger" @click="handleDelete(scope.row.id)" round)
                svg-icon(icon-class="fa-solid trash-alt")
    <!--div.pagination__wrapper-->
      <!--el-pagination(@size-change="handleSizeChange"-->
        <!--@current-change="handleCurrentChange"-->
        <!--:current-page.sync="currentPage"-->
        <!--:page-sizes="[100, 200, 300, 400]"-->
        <!--:page-size="100"-->
        <!--layout="total, sizes, prev, pager, next"-->
        <!--:total="400")-->

</template>

<script>
  import { mapActions } from 'vuex'
  export default {
    name: 'RoleTable',
    data () {
      return {
        currentPage: 1,
        showDialog: false,
        selection: []
      }
    },
    props: {
      roles: {
        type: Array,
        default: () => []
      },
      total: {
        type: Number,
        default: 0
      },
      loading: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      ...mapActions('roles', {
        deleteRole: 'destroy'
      }),
      remove (id) {
        return this.deleteRole({id})
      },
      handleSizeChange (size) {
        this.$emit('on-size-change', size)
      },
      handleCurrentChange (current) {
        this.$emit('on-current-change', current)
      },
      handleEdit (id) {
        this.$emit('on-update', id)
      },
      handleDelete (id) {
        this.$confirm('Bạn muốn xóa quyền này?', 'Xác nhận xóa', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy bỏ',
          type: 'warning',
          confirmButtonClass: 'el-button el-button--danger'
        }).then(() => {
          this.remove(id).then(() => {
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
      onDelete (id) {
        this.$emit('on-delete', id)
        this.showDialog = false
      },
      selectChange (selection) {
       this.$emit('on-selection', selection);
      }
    }
  }
</script>

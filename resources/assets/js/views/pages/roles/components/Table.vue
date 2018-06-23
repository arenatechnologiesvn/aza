<template lang="pug">
  div.index__container
    div.table
      el-table(:data="roles" border  style="width: 100%")
        el-table-column(type="selection" width="40")
        el-table-column(prop="title" label="TÊN QUYỀN" sortable)
        el-table-column(prop="description" label="MÔ TẢ" sortable width="180")
        el-table-column(prop="id" label="TÁC VỤ" width="170")
          template(slot-scope="scope")
            el-button(type="text" size="small" @click="handleEdit(scope.row.id)") Edit
            el-popover(placement="top" trigger="click" width="200")
              p Bạn muốn xóa quyền này?
              div
                el-button(size="mini" type="text" @click="showDialog = false") Hủy
                el-button(size="mini" type="primary" @click="onDelete(scope.row.id)") Đồng ý
              el-button(slot="reference" size="small" type="text") Delete
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-sizes="[100, 200, 300, 400]"
        :page-size="100"
        layout="total, sizes, prev, pager, next"
        :total="total")

</template>

<script>

  export default {
    name: 'RoleTable',
    data () {
      return {
        currentPage: 1,
        showDialog: false
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
      }
    },
    methods: {
      handleSizeChange (size) {
        this.$emit('on-size-change', size)
      },
      handleCurrentChange (current) {
        this.$emit('on-current-change', current)
      },
      handleEdit (id) {
        this.$emit('on-update', id)
      },
      onDelete (id) {
        this.$emit('on-delete', id)
        this.showDialog = false
      }
    }
  }
</script>

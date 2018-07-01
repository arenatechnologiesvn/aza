<template lang="pug">
  div.index__container
    div.table
      el-table(:data="employees.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
        el-table-column(type="selection" width="40")
        el-table-column(prop="avatar" width="60")
          template(slot-scope="scope")
            img(:src="scope.row.avatar" width="40" height="40")
        el-table-column(prop="full_name" label="HỌ TÊN" sortable min-width="200")
        el-table-column(prop="phone" label="ĐIỆN THOẠI" sortable width="120")
        el-table-column(prop="email" label="EMAIL" sortable width="180")
        el-table-column(prop="customer_count" label="SỐ KHÁCH HÀNG" sortable width="140"  :formatter="(row, column) => `${row.customer_count} Khách hàng`")
        el-table-column(prop="role_name" label="VAI TRÒ" sortable width="180")
        el-table-column(prop="is_active" label="TRẠNG THÁI" sortable width="120")
          template(slot-scope="scope")
            el-switch(v-model="scope.row.is_active" @change="onChangeStatus(scope.row.id, scope.row.is_active)")
        el-table-column(prop="id" label="TÁC VỤ" width="130" fixed="right")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Chỉnh sửa" placement="top")
              el-button(size="mini" @click="handleEdit(scope.row.id)" round)
                svg-icon(icon-class="fa-solid user-edit")
            el-tooltip(effect="dark" content="Xóa" placement="top")
              el-button(size="mini" type="danger" @click="onDelete(scope.row.id)" round)
                svg-icon(icon-class="fa-solid trash-alt")
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[1, 5, 10, 20, 40]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="employees.length")

</template>

<script>

  export default {
    name: 'EmployeeTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
      }
    },
    props: {
      employees: {
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
      onChangeStatus(id, isActive) {
        this.$emit('on-change-status', id, {
          id: id,
          is_active: isActive
        })
      }
    }
  }
</script>
<template lang="pug">
  div.index__container
    div.table
      el-table(:data="customers.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
        el-table-column(type="selection" width="40")
        el-table-column(prop="avatar" width="60")
          template(slot-scope="scope")
            img(:src="scope.row.avatar" width="40" height="40")
        el-table-column(prop="code" label="MÃ KH" sortable min-width="100")
        el-table-column(prop="user.full_name" label="HỌ TÊN" sortable min-width="120")
        el-table-column(prop="employee.user.full_name" label="NHÂN VIÊN PHỤ TRÁCH" sortable min-width="180")
        el-table-column(prop="user.phone" label="ĐIỆN THOẠI" sortable width="120")
        el-table-column(prop="user.email" label="EMAIL" sortable width="150")
        el-table-column(prop="shops.length" label="SỐ CỬA HÀNG" sortable width="130")
        el-table-column(prop="customer_type" label="LOẠI" sortable width="100")
          template(slot-scope="scope")
            span {{scope.row.customer_type == 1 ? 'VIP' : 'THƯỜNG'}}
        el-table-column(prop="is_active" label="TRẠNG THÁI" sortable width="120")
          template(slot-scope="scope")
            el-switch(v-model="scope.row.user.is_active" @change="onChangeStatus(scope.row.id, scope.row.user.is_active)")
        el-table-column(prop="id" label="TÁC VỤ" width="120" fixed="right")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Chỉnh sửa" placement="top")
              el-button(size="mini" @click="onEdit(scope.row.id)" round)
                svg-icon(icon-class="fa-solid user-edit")
            el-tooltip(effect="dark" content="Xóa" placement="top")
              el-button(size="mini" type="danger" @click="onDelete(scope.row.id)" round)
                svg-icon(icon-class="fa-solid trash-alt")
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[5, 10, 20, 40]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="customers.length")
</template>

<script>

  export default {
    name: 'CustomerTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
      }
    },
    props: {
      customers: {
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
      onEdit (id) {
        this.$emit('on-update', id)
      },
      onDelete (id) {
        this.$emit('on-delete', id)
        this.showDialog = false
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
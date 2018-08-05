<template lang="pug">
  div.index__container
    div.table
      el-table(:data="orders.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
        el-table-column(type="selection" width="40")
        el-table-column(prop="order_code" label="MÃ ĐƠN HÀNG" sortable min-width="140")
        el-table-column(prop="customer.code" label="MÃ KH" sortable width="170")
        el-table-column(prop="status" label="TRẠNG THÁI" sortable width="140")
          template(slot-scope="scope")
            el-switch(v-model="scope.row.status === 1" @change="onChangeStatus(scope.row.id, scope.row.status)")
        el-table-column(prop="apply_at" label="NGÀY ĐẶT" sortable width="140")
        el-table-column(prop="delivery" label="NGÀY GIAO" sortable width="140")
        el-table-column(prop="delivery_type" label="GIỜ GIAO" sortable width="140")
        el-table-column(prop="total_money" label="TỔNG TIỀN" sortable width="140")
        el-table-column(prop="id" label="TÁC VỤ" width="130" fixed="right")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Xem chi tiết" placement="top")
              el-button(size="mini" @click="handleEdit(scope.row.id)" :disabled="parseInt(scope.row.status) !== 0" round)
                svg-icon(icon-class="fa-solid eye")
            el-tooltip(effect="dark" content="Hủy đơn hàng" placement="top")
              el-button(size="mini" type="danger" @click="onDelete(scope.row.id)" :disabled="parseInt(scope.row.status) !== 0" round)
                svg-icon(icon-class="fa-solid ban")
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[10, 20, 30, 50]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="orders.length")

</template>

<script>

  export default {
    name: 'OrderTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
      }
    },
    props: {
      orders: {
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
      onChangeStatus(id, status) {
        this.$emit('on-change-status', id, {
          status: !status
        })
      }
    }
  }
</script>
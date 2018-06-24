<template lang="pug">
  div.index__container
    div.table
      el-table(:data="customers" border  style="width: 100%")
        el-table-column(type="selection" width="40")
        el-table-column(prop="avatar" width="80" label="AVATAR")
          template(slot-scope="scope")
            img(:src="scope.row.avatar" width="50" height="50")
        el-table-column(prop="full_name" label="HỌ TÊN" sortable)
        el-table-column(prop="phone" label="ĐIỆN THOẠI" sortable width="180")
        el-table-column(prop="email" label="EMAIL" sortable width="180")
        el-table-column(prop="customer_type" label="LOẠI" sortable width="180")
          template(slot-scope="scope")
            span {{scope.row.customer_type == 1 ? 'VIP' : 'THƯỜNG'}}
        el-table-column(prop="id" label="TÁC VỤ" width="100")
          template(slot-scope="scope")
            el-button(type="text" size="small" @click="handleEdit(scope.row.id)") Edit
            label(style="width: 15px; display: inline-block; text-align: center") /
            el-button(@click="dialogShow = true" size="small" type="text" style="color: red" ) Delete
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[5, 10, 20, 40]"
          :page-size="10"
      layout="total, sizes, prev, pager, next"
        :total="total")
    div
      el-dialog(title="Xóa khách hàng"
        :visible.sync="dialogShow"
      width="30%"
      center)
        span  Bạn muốn xóa khách hàng nảy
        span(slot="footer" class="dialog-footer")
          el-button(@click="dialogShow = false") Hủy
          el-button(type="primary" @click="dialogShow = false") Đồng ý
</template>

<script>

  export default {
    name: 'CustomerTable',
    data () {
      return {
        dialogShow: false,
        currentPage: 1,
        showDialog: false
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
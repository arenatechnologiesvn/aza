<template lang="pug">
  div.index__container
    div.table
      el-table(:data="shops" border  style="width: 100%")
        el-table-column(type="selection" width="40")
        el-table-column(prop="preview_image" width="80" label="AVATAR")
          template(slot-scope="scope")
            img(:src="scope.row.preview_image" width="50" height="50")
        el-table-column(prop="name" label="TÊN CỬA HÀNG" sortable)
        el-table-column(prop="phone" label="ĐIỆN THOẠI" sortable width="180")
        el-table-column(prop="description" label="GIỚI THIỆU")
        el-table-column(prop="customer_name" label="CHỦ CỬA HÀNG" sortable width="180")
        el-table-column(prop="address" label="ĐỊA CHỈ" sortable width="180")
        el-table-column(prop="id" label="TÁC VỤ" width="100")
          template(slot-scope="scope")
            el-button(type="text" size="small" @click="handleEdit(scope.row.id)") Edit
            label(style="width: 15px; display: inline-block; text-align: center") /
            el-button(size="small" type="text" style="color: red;" @click="shopDel= true") Delete
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[5, 10, 20, 40]"
          :page-size="10"
        layout="total, sizes, prev, pager, next"
        :total="total")
    div
      el-dialog(title="Xóa cửa hàng"
        :visible.sync="shopDel"
        width="30%"
        center)
        span  Bạn muốn xóa của hàng này
        span(slot="footer" class="dialog-footer")
          el-button(@click="shopDel = false") Hủy
          el-button(type="primary" @click="shopDel = false") Đồng ý

</template>

<script>

  export default {
    name: 'ShopTable',
    data () {
      return {
        currentPage: 1,
        showDialog: false,
        shopDel: false
      }
    },
    props: {
      shops: {
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
        this.currentPage = current
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

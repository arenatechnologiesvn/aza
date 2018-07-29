<template lang="pug">
  div.index__container
    div.table
      el-table(:data="shops.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
        el-table-column(type="selection" width="40")
        el-table-column(prop="preview_image" width="60")
          template(slot-scope="scope")
            img(:src="scope.row.preview_image" width="40" height="40")
        el-table-column(prop="name" label="TÊN CỬA HÀNG" min-width="200" sortable)
        el-table-column(prop="phone" label="ĐIỆN THOẠI" sortable width="180")
        el-table-column(prop="customer.user.full_name" label="CHỦ CỬA HÀNG" sortable width="180")
        el-table-column(prop="address" label="ĐỊA CHỈ" sortable width="180")
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
          :page-sizes="[1, 5, 10, 20, 40]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="shops.length")

</template>

<script>

  export default {
    name: 'ShopTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
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
      }
    }
  }
</script>

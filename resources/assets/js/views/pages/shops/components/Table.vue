<template lang="pug">
  div.index__container
    div.table
      el-table(:data="shops.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
        //- el-table-column(type="selection" width="40")
        el-table-column(prop="num" label="STT" align="center" width="60")
          template(slot-scope="scope")
            span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
        el-table-column(prop="name" label="TÊN CỬA HÀNG" min-width="200" sortable)
        el-table-column(prop="phone" label="ĐIỆN THOẠI" sortable width="180")
        el-table-column(prop="customer.user.full_name" label="KHÁCH HÀNG" sortable width="180")
        el-table-column(prop="address" label="ĐỊA CHỈ" sortable width="200")
        el-table-column(prop="zone" label="VÙNG" sortable min-width="300")
          template(slot-scope="scope")
            span {{ scope.row.zone || '-' }}
        el-table-column(prop="id" label="TÁC VỤ" width="120" fixed="right")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Chỉnh sửa" placement="top" v-if="editEnable")
              el-button(size="mini" @click="onEdit(scope.row.id)" round)
                svg-icon(icon-class="fa-solid user-edit")
            el-tooltip(effect="dark" content="Xóa" placement="top")
              el-button(size="mini" type="danger" @click="onDelete(scope.row.id)" round)
                  svg-icon(icon-class="fa-solid trash-alt")
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[10, 20, 30, 50]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="shops.length")

</template>

<script>
  import {checkPermission} from '~/utils/util'
  import {EDIT_SHOP} from '~/utils/const'
  export default {
    name: 'ShopTable',
    computed: {
      editEnable () {
        return checkPermission(EDIT_SHOP, this.$store.getters.mpermissions)
      }
    },
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

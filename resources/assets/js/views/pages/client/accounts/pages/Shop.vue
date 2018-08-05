<template lang="pug">
  div.index__container
    el-card(style="text-align: left")
      div(slot="header" class="clearfix")
        span
          svg-icon(icon-class="fa-solid store-alt")
          span(style="margin-left: 10px;") DANH SÁCH CỬA HÀNG
      div.table
        el-table(:data="shops.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
          el-table-column(prop="name" label="TÊN CỬA HÀNG" min-width="200" sortable)
          el-table-column(prop="phone" label="ĐIỆN THOẠI" sortable width="110")
          el-table-column(prop="address" label="ĐỊA CHỈ" sortable width="150")
          el-table-column(prop="zone" label="VÙNG" sortable min-width="300")
            template(slot-scope="scope")
              span {{ scope.row.zone || '-' }}
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
  import {mapGetters, mapActions} from 'vuex'
  import ElCard from "element-ui/packages/card/src/main";
  export default {
    components: {ElCard},
    name: 'ShopTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
      }
    },
    computed: {
      ...mapGetters('shops', {
        listShops: 'list'
      }),
      ...mapGetters(['user_info']),
      shops () {
        return this.listShops.filter(item => parseInt(item.customer_id) === parseInt(this.user_info.customer.id))
      }
    },
    methods: {
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
      }
    },
    created () {
      this.$store.dispatch('shops/fetchList')
    }
  }
</script>

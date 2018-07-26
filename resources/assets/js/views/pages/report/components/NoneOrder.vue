<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Các khách hàng từ 4 ngày trở lên không đặt hàng
    div
      .control__wrapper
        el-row
          el-col(:span="24" style="text-align: right")
            el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="max-width: 400px; margin-left: 5px;" size="small")
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="num" label="STT" align="center" width="60")
              el-table-column(prop="customer_name" label="TÊN KHÁCH HÀNG" sortable min-width="200")
              el-table-column(prop="employee_name" label="NHÂN VIÊN PHỤ TRÁCH" sortable min-width="200")
              el-table-column(prop="last_order" label="ĐẶT HÀNG LẦN CUỐI" sortable min-width="200")
                template(slot-scope="scope")
                  span {{ scope.row.last_order || '-' }}
          div.pagination__wrapper
            el-pagination(:current-page.sync="currentPage"
              :page-sizes="[10, 20, 30, 50]"
              :page-size="10"
              layout="total, sizes, prev, pager, next"
              :total="tableData.length")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';

export default {
  name: 'none-order',
  computed: {
    ...mapGetters({
      noneOrderCustomers: 'report/noneOrderCustomers'
    })
  },
  created() {
    this.fetchNoneOrderCustomers().catch(() => {
      //  Do nothing
    })
  },
  data() {
    return {
      tableData: [],
      currentPage: 1,
      searchWord: ''
    }
  },
  methods: {
    ...mapActions({
      fetchNoneOrderCustomers: 'report/fetchNoneOrderCustomers'
    })
  },
  watch: {
    noneOrderCustomers() {
      if (this.noneOrderCustomers) {
        this.tableData = JSON.parse(JSON.stringify(this.noneOrderCustomers));
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid shipping-fast")
        span(style="margin-left: 10px;") SẢN PHẨM BÁN CHẠY
    .table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%")
            el-table-column(prop="num" label="STT" align="center" width="60")
              template(slot-scope="scope")
                span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
            el-table-column(prop="product_name" label="SẢN PHẨM" sortable min-width="200")
            el-table-column(prop="order_total" label="TỔNG HÓA ĐƠN" sortable min-width="120")
              template(slot-scope="scope")
                span {{ scope.row.order_total || 0 }}
            el-table-column(prop="revenue_total" label="TỔNG DOANH THU (₫)" sortable min-width="200")
              template(slot-scope="scope")
                span {{ Number(scope.row.revenue_total).toLocaleString('de-DE') }}
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[5, 10, 20, 30, 50]"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next"
            :total="totalDataNum"
            @size-change="sizeChange")
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

const DEDAULT_PAGE_SIZE = 5;

export default {
  name: 'sold-well-products',
  computed: {
    ...mapGetters({
      soldWellProducts: 'report/soldWellProducts'
    }),

    tableData() {
      return this.filteredData(this.soldWellProducts);
    }
  },
  created() {
    this.getSoldWellProducts();
  },
  data() {
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE
    }
  },
  methods: {
    getSoldWellProducts() {
      this.fetchSoldWellProducts().catch(() => {
        // Do nothing
      });
    },

    filteredData(data) {
      // Set total size before cutting for paging
      this.totalDataNum = data.length;

      // Paging and Adding Adsets
      const results = [];
      const offset = (this.currentPage - 1) * this.pageSize;
      data.forEach((item, index, array) => {
        if (index < offset) return;
        if (index >= offset + this.pageSize) return;
        results.push(item);
      });

      return results;
    },

    sizeChange(newPageSize) {
      this.pageSize = newPageSize;
    },

    ...mapActions({
      fetchSoldWellProducts: 'report/fetchSoldWellProducts'
    })
  }
}
</script>

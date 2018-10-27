<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Dự kiến chi tiết số lượng xuất bán trong ngày
    div
      .control__wrapper
        el-row
          el-col(:span="20")
            el-date-picker(
              v-model="selectedDate"
              type="daterange"
              range-separator="Tới"
              start-placeholder="Ngày bắt đầu"
              end-placeholder="Ngày kết thúc"
              format="dd-MM-yyyy"
              value-format="dd-MM-yyyy"
              style="margin-right: 5px; min-width: 500px"
              size="small"
            )
          el-col(:span="4" style="text-align: right")
            el-button(type="success" size="small" @click="exportExcelFile" :disabled="!this.sellingProducts.length")
              svg-icon(icon-class="fa-solid file-excel")
              span.ml-5  Xuất Excel
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="num" label="#" align="center" width="60")
                template(slot-scope="scope")
                  span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
              el-table-column(type="expand")
                template(slot-scope="props")
                  el-table.product(:data="props.row.customers" border="border" size="mini")
                    el-table-column(prop="num" label="#" align="center" width="60")
                      template(slot-scope="scope")
                        span {{ scope.$index + 1 }}
                    el-table-column(prop="customer_code" label="MÃ KH" min-width="150")
                    el-table-column(prop="customer_name" label="TÊN KH" min-width="200")
                    el-table-column(prop="quantity_total" label="SỐ LƯỢNG" min-width="120")
                    el-table-column(prop="mass_total" label="TỔNG KHỐI LƯỢNG" min-width="180")
                      template(slot-scope="scope")
                        span {{ scope.row.mass_total || '-' }}
                    el-table-column(prop="revenue_total" label="TỔNG TIỀN (VND)" min-width="200")
                      template(slot-scope="scope")
                        span {{ Number(scope.row.revenue_total).toLocaleString('de-DE') }}
              el-table-column(prop="product_code" label="MÃ SẢN PHẨM" min-width="150")
              el-table-column(prop="product_name" label="TÊN SẢN PHẨM" min-width="200")
              el-table-column(prop="quantity_total" label="SỐ LƯỢNG" min-width="120")
              el-table-column(prop="product_quantitative" label="ĐỊNH LƯỢNG" min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.product_quantitative || '-' }}
              el-table-column(prop="mass_total" label="TỔNG KHỐI LƯỢNG" min-width="180")
                template(slot-scope="scope")
                  span {{ scope.row.mass_total || '-' }}
              el-table-column(prop="revenue_total" label="TỔNG TIỀN (VND)" min-width="200")
                template(slot-scope="scope")
                  span {{ Number(scope.row.revenue_total).toLocaleString('de-DE') }}
          div.pagination__wrapper
            el-pagination(:current-page.sync="currentPage"
              :page-sizes="[10, 20, 30, 50]"
              :page-size="pageSize"
              layout="total, sizes, prev, pager, next"
              :total="totalDataNum"
              @size-change="sizeChange")
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import excelExport from '~/utils/excel/export2Excel.js';
import moment from 'moment';

const DEDAULT_PAGE_SIZE = 10;

export default {
  name: 'selling-products',
  computed: {
    ...mapGetters({
      sellingProducts: 'report/sellingProducts'
    }),

    tableData() {
      return this.filteredData(this.sellingProducts);
    }
  },
  created() {
    this.getRevenue();
  },
  data() {
    const currentDate = moment().format('DD-MM-YYYY');
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      selectedDate: [currentDate, currentDate],
    }
  },
  methods: {
    getRevenue() {
      if (this.canGetRevenue()) {
        const params = {
          startDate: this.selectedDate[0],
          endDate: this.selectedDate[1]
        }

        this.fetchSellingProducts(params).catch(() => {
          // Do nothing
        });
      }
    },

    canGetRevenue() {
      return this.selectedDate.length;
    },

    filteredData(data) {
      // Set total size before cutting for paging
      this.totalDataNum = data.length;

      // Paging
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

    exportExcelFile() {
      const exportData = this.sellingProducts.map((item, index) => {
        return {
          "STT": index + 1,
          "MÃ SẢN PHẨM": item.product_code,
          "TÊN SẢN PHẨM": item.product_name,
          "SỐ LƯỢNG": item.quantity_total,
          "ĐỊNH LƯỢNG": item.product_quantitative || '-',
          "TỔNG KHỐI LƯỢNG": item.mass_total || '-',
          "TỔNG TIỀN (VND)": Number(item.revenue_total).toLocaleString('de-DE')
        };
      });

      excelExport(`${this.selectedDate[0]}_DSSP_XUAT_BAN`, exportData).then(() => {
        // Do nothing
      }).catch(() => {
        // Do nothing
      });
    },

    ...mapActions({
      fetchSellingProducts: 'report/fetchSellingProducts'
    })
  },
  watch: {
    selectedDate() {
      this.getRevenue();
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

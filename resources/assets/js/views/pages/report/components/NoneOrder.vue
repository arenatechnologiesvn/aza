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
                template(slot-scope="scope")
                  span {{ scope.$index + 1 }}
              el-table-column(prop="customer_name" label="TÊN KHÁCH HÀNG" sortable min-width="200")
              el-table-column(prop="employee_name" label="NHÂN VIÊN PHỤ TRÁCH" sortable min-width="200")
              el-table-column(prop="last_order" label="ĐẶT HÀNG LẦN CUỐI" sortable min-width="200")
                template(slot-scope="scope")
                  span {{ scope.row.last_order || 'Chưa đặt hàng lần nào' }}
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

const DEDAULT_PAGE_SIZE = 10;

export default {
  name: 'none-order',
  computed: {
    ...mapGetters({
      noneOrderCustomers: 'report/noneOrderCustomers'
    }),

    tableData() {
      return this.extractData(this.noneOrderCustomers);
    }
  },
  created() {
    this.fetchNoneOrderCustomers().catch(() => {
      //  Do nothing
    })
  },
  data() {
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      searchWord: ''
    }
  },
  methods: {
    filterData(data) {
      const filterWord = this.searchWord && this.searchWord.toLowerCase();

      if (filterWord !== '') {
        filterWord.trim().split(/\s/).forEach(word => {
          data = data.filter(item => {
            return item.customer_name.toLowerCase().indexOf(word) > -1 ||
              item.employee_name.toLowerCase().indexOf(word) > -1;
          });
        });
      }

      return data;
    },

    extractData(data) {
      // Search data
      data = this.filterData(data);

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
      fetchNoneOrderCustomers: 'report/fetchNoneOrderCustomers'
    })
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

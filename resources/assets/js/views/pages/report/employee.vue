<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Tổng doanh số của nhân viên kinh doanh
    div
      .control__wrapper
        el-row
          el-col(:span="21")
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
            el-select(v-model="selectedEmployee" clearable placeholder="Nhân viên" size="small")
              el-option(v-for="item in employees" :key="item.id" :label="item.user.last_name + ' ' + item.user.first_name" :value="item.id")
          el-col(:span="3" style="text-align: right")
            el-button(type="success" size="small" @click="getRevenue" :disabled="!canGetRevenue()")
              svg-icon(icon-class="fa-solid check")
              span.ml-5  Xem
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="num" label="STT" align="center" width="60")
                template(slot-scope="scope")
                  span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
              el-table-column(prop="name" label="TÊN KHÁCH HÀNG" sortable min-width="200")
              el-table-column(prop="revenue_total" label="TỔNG DOANH SỐ  (₫)" sortable min-width="200")
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

const DEDAULT_PAGE_SIZE = 10;

export default {
  name: 'employee-report',
  computed: {
    ...mapGetters({
      employees: 'employees/list',
      employeeRevenue: 'report/employeeRevenue'
    }),

    tableData() {
      return this.filteredData(this.employeeRevenue);
    }
  },
  created() {
    this.fetchEmployees().catch(() => {
      // Do nothing
    });
  },
  data() {
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      selectedEmployee: '',
      selectedDate: []
    }
  },
  methods: {
    getRevenue() {
      if (this.canGetRevenue()) {
        this.fetchEmployeeRevenue({
          employeeId: this.selectedEmployee,
          startDate: this.selectedDate[0],
          endDate: this.selectedDate[1]
        }).catch(() => {
          // Do nothing
        });
      }
    },

    canGetRevenue() {
      return this.selectedEmployee && this.selectedDate.length;
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
      fetchEmployees: 'employees/fetchList',
      fetchEmployeeRevenue: 'report/fetchEmployeeRevenue'
    })
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

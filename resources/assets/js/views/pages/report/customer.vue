<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Tổng doanh thu theo từng khách hàng và sản phẩm
    div(style="margin-bottom: 50px")
      revenue-chart(:options="chartOptions" ref="revenueChart")
    div
      .control__wrapper
        el-row
          el-col(:span="24" style="text-align: center")
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
            el-select(v-model="selectedCustomer" clearable placeholder="Khách hàng" size="small")
              el-option(v-for="item in customers" :key="item.id" :label="item.user.last_name + ' ' + item.user.first_name" :value="item.id")
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="num" label="STT" align="center" width="60")
                template(slot-scope="scope")
                  span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
              el-table-column(prop="product_name" label="TÊN SẢN PHẨM" sortable min-width="200")
              el-table-column(prop="quantity_total" label="SỐ LƯỢNG" sortable min-width="120")
              el-table-column(prop="product_quantitative" label="ĐỊNH LƯỢNG" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.product_quantitative || '-' }}
              el-table-column(prop="mass_total" label="KHỐI LƯỢNG" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.mass_total || '-' }}
              el-table-column(prop="revenue_total" label="DOANH SỐ  (₫)" sortable min-width="200")
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
import RevenueChart from '~/components/Chart/BarChart';
import moment from 'moment';

const DEDAULT_PAGE_SIZE = 10;

export default {
  name: 'customer-report',
  components: {
    RevenueChart
  },
  computed: {
    ...mapGetters({
      customers: 'customers/list',
      customerRevenue: 'report/customerRevenue'
    }),

    tableData() {
      return this.filteredData(this.customerRevenue);
    }
  },
  created() {
    this.fetchCustomers().catch(() => {
      // Do nothing
    });
    this.getRevenue();
  },
  data() {
    const currentDate = moment().format('DD-MM-YYYY');
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      selectedCustomer: '',
      selectedDate: [currentDate, currentDate],
      chartOptions: {
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross',
            crossStyle: {
              color: '#999'
            }
          }
        },
        grid: {
          top: 50,
          left: '2%',
          right: '2%',
          bottom: '3%',
          containLabel: true
        },
        legend: {
          data:['Biểu đồ cột']
        },
        xAxis: [{
          type: 'category',
          data: [],
          axisPointer: {
            type: 'shadow'
          }
        }],
        yAxis: [{
          type: 'value',
          name: 'Doanh số (₫)',
          min: 0,
          interval: 50
        }],
        series: [{
          name:'Biểu đồ cột',
          type:'bar',
          barWidth: '40%',
          data:[]
        }]
      }
    }
  },
  methods: {
    getRevenue() {
      if (this.canGetRevenue()) {
        const params = {
          startDate: this.selectedDate[0],
          endDate: this.selectedDate[1]
        }
        if (this.selectedCustomer) params.customerId = this.selectedCustomer;

        this.fetchCustomerRevenue(params).catch(() => {
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

    refreshChartOptions() {
      const xAxis = [];
      const serieData = [];
      this.customerRevenue.forEach(item => {
        xAxis.push(item.product_name);
        serieData.push(item.revenue_total);
      });
      this.chartOptions.xAxis[0].data = xAxis;
      this.chartOptions.series[0].data = serieData;
      this.$refs.revenueChart.refresh(this.chartOptions);
    },

    ...mapActions({
      fetchCustomers: 'customers/fetchList',
      fetchCustomerRevenue: 'report/fetchCustomerRevenue'
    })
  },
  watch: {
    selectedCustomer() {
      this.getRevenue();
    },

    selectedDate() {
      this.getRevenue();
    },

    customerRevenue() {
      this.refreshChartOptions();
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

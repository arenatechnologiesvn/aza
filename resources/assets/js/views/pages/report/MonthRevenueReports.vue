<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-bar")
        span(style="margin-left: 10px;") DOANH THU THEO THÁNG
    div(style="margin-bottom: 50px")
      month-revenue-chart(:options="chartOptions" ref="monthRevenueChart")
    .control__wrapper
      el-row
        el-col(:span="24" style="text-align: right")
          span(style="margin-right: 5px") Chọn tháng:
          el-date-picker(
            v-model="selectedMonth"
            type="month"
            format="MM-yyyy"
            value-format="MM-yyyy"
            placeholder="Chọn tháng"
            size="small"
          )
    .table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%")
            el-table-column(prop="num" label="STT" align="center" width="60")
              template(slot-scope="scope")
                span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
            el-table-column(prop="week" label="NGÀY" sortable min-width="200")
            el-table-column(prop="revenue" label="DOANH THU" sortable min-width="120")
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[5, 10, 20, 30, 50]"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next"
            :total="totalDataNum"
            @size-change="sizeChange")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import MonthRevenueChart from '~/components/Chart/BarChart'
const DEDAULT_PAGE_SIZE = 5;

export default {
  name: 'month-revenue-reports',
  components: {
    MonthRevenueChart
  },
  computed: {
    ...mapGetters({
      accessStatistical: 'report/accessStatistical'
    }),

    tableData() {
      return this.filteredData(this.accessStatistical);
    }
  },
  created() {

  },
  data() {
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      selectedMonth: '',
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
          data:['Biểu đồ cột', 'Biểu đồ đường']
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
          name: 'Số lần truy cập',
          min: 0,
          interval: 50
        }],
        series: [{
          name:'Biểu đồ cột',
          type:'bar',
          barWidth: '40%',
          data:[]
        }, {
          name:'Biểu đồ đường',
          type:'line',
          yAxisIndex: 0,
          data:[]
        }]
      }
    }
  },
  methods: {
    getStatistical() {
      if (this.canGetStatistical()) {
        this.fetchCustomerAccessStatistical({
          customerId: this.selectedCustomer,
          startDate: this.selectedDate[0],
          endDate: this.selectedDate[1]
        }).catch(() => {
          // Do nothing
        });
      }
    },

    canGetStatistical() {
      return this.selectedCustomer && this.selectedDate.length;
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
      this.accessStatistical.forEach(item => {
        xAxis.push(item.access_day);
        serieData.push(item.access_count);
      });
      this.chartOptions.xAxis[0].data = xAxis;
      this.chartOptions.series[0].data = serieData;
      this.chartOptions.series[1].data = serieData;
      this.$refs.monthRevenueChart.refresh(this.chartOptions);
    },

    ...mapActions({
      fetchCustomerAccessStatistical: 'report/fetchCustomerAccessStatistical'
    })
  },
  watch: {
    selectedCustomer() {
      if (this.canGetStatistical()) this.getStatistical();
    },

    selectedDate() {
      if (this.canGetStatistical()) this.getStatistical();
    },

    accessStatistical() {
      if (this.accessStatistical.length) {
        this.refreshChartOptions();
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

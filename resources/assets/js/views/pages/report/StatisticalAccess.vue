<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Tổng lượng truy cập vào website
    div(style="margin-bottom: 50px")
      access-chart(:options="chartOptions" ref="accessChart")
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
              el-table-column(prop="access_day" label="NGÀY TRUY CẬP" sortable min-width="200")
              el-table-column(prop="access_count" label="SỐ LẦN" sortable min-width="120")
          div.pagination__wrapper
            el-pagination(:current-page.sync="currentPage"
              :page-sizes="[10, 20, 30, 50]"
              :page-size="pageSize"
              layout="total, sizes, prev, pager, next"
              :total="totalDataNum"
              @size-change="sizeChange")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import AccessChart from '~/components/Chart/BarChart'
const DEDAULT_PAGE_SIZE = 10;

export default {
  name: 'statistical-access',
  components: {
    AccessChart
  },
  computed: {
    ...mapGetters({
      customers: 'customers/list',
      accessStatistical: 'report/accessStatistical'
    }),

    tableData() {
      return this.filteredData(this.accessStatistical);
    }
  },
  created() {
    this.fetchCustomers().catch(() => {
      // Do nothing
    });
  },
  data() {
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      selectedDate: [],
      selectedCustomer: '',
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
      this.$refs.accessChart.refresh(this.chartOptions);
    },

    ...mapActions({
      fetchCustomers: 'customers/fetchList',
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

<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-bar")
        span(style="margin-left: 10px;") DOANH THU THEO NĂM
    div(style="margin-bottom: 20px")
      year-revenue-chart(:options="chartOptions" ref="yearRevenueChart")
    .control__wrapper
      el-row
        el-col(:span="24" style="text-align: right")
          span(style="margin-right: 5px") Chọn năm:
          el-date-picker(
            v-model="selectedYear"
            type="year"
            format="yyyy"
            value-format="yyyy"
            placeholder="Kích vào để chọn năm"
            size="small"
          )
    .table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%")
            el-table-column(prop="num" label="STT" align="center" width="60")
              template(slot-scope="scope")
                span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
            el-table-column(prop="month" label="THÁNG" sortable min-width="200")
            el-table-column(prop="revenue" label="DOANH THU (VND)" sortable min-width="120")
              template(slot-scope="scope")
                span {{ Number(scope.row.revenue).toLocaleString('de-DE') }}
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
import YearRevenueChart from '~/components/Chart/BarChart';
import moment from 'moment';

const DEDAULT_PAGE_SIZE = 5;

export default {
  name: 'year-revenue-reports',
  components: {
    YearRevenueChart
  },
  computed: {
    ...mapGetters({
      yearRevenues: 'report/yearRevenues'
    }),

    tableData() {
      return this.filteredData(this.yearRevenues);
    }
  },
  created() {
    this.getRevenues();
  },
  data() {
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      selectedYear: moment().format('YYYY'),
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
          name: 'Doanh thu (VND)',
          min: 0,
          interval: 100000000
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
    getRevenues() {
      this.fetchRevenues({
        type: 'year',
        year: this.selectedYear
      }).then(() => {
        this.refreshChartOptions();
      }).catch(() => {
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

    refreshChartOptions() {
      const xAxis = [];
      const serieData = [];
      this.yearRevenues.forEach(item => {
        xAxis.push(item.month);
        serieData.push(item.revenue);
      });
      this.chartOptions.xAxis[0].data = xAxis;
      this.chartOptions.series[0].data = serieData;
      this.chartOptions.series[1].data = serieData;
      this.$refs.yearRevenueChart.refresh(this.chartOptions);
    },

    ...mapActions({
      fetchRevenues: 'report/fetchRevenues'
    })
  },
  watch: {
    selectedYear() {
      this.getRevenues();
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

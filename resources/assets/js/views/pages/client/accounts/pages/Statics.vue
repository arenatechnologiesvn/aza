<template lang="pug">
  div
    el-card(class="box-card")
      div(slot="header" class="clearfix" style="text-align: left")
        el-row(:gutter="10")
          el-col(:span="8")
            svg-icon(icon-class="fa-solid chart-bar")
            span(style="margin-left: 10px;") Thống kê sản phẩm được mua
          el-col(:span="type == 1 ? 16 : 12")
            div(style="text-align: right;")
              el-radio-group(v-model="type" size="mini")
                el-radio-button(label="1") Hôm nay
                el-radio-button(label="4") Theo ngày
                el-radio-button(label="2") Theo tháng
                el-radio-button(label="3") Theo năm
          el-col(:span="4" v-show="type == 2 || type == 3 || type==4")
            el-date-picker(
              :type="type == 3 ? 'year' : type == 2 ? 'month' : 'date'"
              :format="type == 3 ? 'yyyy' : type == 2  ? 'yyyy-MM' : 'yyyy-MM-dd'"
              :value-format="type == 3 ? 'yyyy' : type == 2  ? 'yyyy-MM' : 'yyyy-MM-dd'"
              v-model="date" size="mini" style="width: 100%;")
      div
        chart(:options="chartOptions" ref="statics" size="mini" @detail="showDetail")
    el-card(class="box-card")
      div(slot="header" class="clearfix" style="text-align: left")
        svg-icon(icon-class="fa-solid hand-holding-usd")
        span(style="margin-left: 10px;") DANH SÁCH SẢN PHẨM
        span(style="float: right;")
          el-date-picker(type="date" :format="'yyyy-MM-dd'" :value-format="'yyyy-MM-dd'" style="width:150px; margin: 0 5px;" v-model="from" size="mini")
          el-date-picker(type="date" :format="'yyyy-MM-dd'" :value-format="'yyyy-MM-dd'" style="width: 150px;" v-model="to" size="mini")
      div
        el-table(:data="tableData" border size="small" style="width: 100%; text-align: left;")
          el-table-column(prop="num" label="STT" align="center" width="60")
            template(slot-scope="scope")
              span {{ (scope.$index + 1)}}
          el-table-column(prop="pname" label="Tên sản phẩm" sortable min-width="200")
          el-table-column(prop="unit" label="Đơn vị tính" min-width="100")
          el-table-column(prop="quantitative" label="Định lượng" min-width="100")
          el-table-column(prop="quantity" label="SL" sortable min-width="80")
          el-table-column(prop="price" label="Đơn giá (VNĐ)" sortable min-width="120" :formatter="(row, column, value) => formatNumber(value)")
          el-table-column(prop="revenue_total" label="Chi phí (VNĐ)" sortable min-width="120" :formatter="(row, column, value) => formatNumber(value)")
</template>

<script>
  import Chart from '~/components/Chart/BarChart';
  import {today, byMonth, byYear, byDay, byRange} from '~/api/client'
  import {formatNumber} from '~/utils/util'
  export default {
    name: 'Statics',
    components: {
      Chart
    },
    data () {
      return {
        type: 1,
        date: new Date,
        from: new Date,
        to: new Date,
        tableData: [],
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
            data:['Chi phí', 'Số lượng']
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
            name: 'Chi phí (VND)',
            min: 0,
            interval: 100000000
          },
            {
              type: 'value',
              name: 'Số lượng',
              position: 'right',
              min: 0
            }],
          series: [{
            name:'Chi phí',
            type:'bar',
            barWidth: '40%',
            data:[]
          }, {
            name:'Số lượng',
            type:'line',
            yAxisIndex: 1,
            data:[]
          }]
        }
      }
    },
    mounted () {
      this.refresh()
    },
    watch: {
      type: function () {
        if(this.type == 1) {
          this.date = new Date
        }
        this.refresh()
      },
      date: 'refresh',
      from: 'refreshTable',
      to: 'refreshTable'
    },
    methods: {
      formatNumber(num) {
        return formatNumber(num)
      },
      assignData (res) {
        const { data } = res
        const names = data.map(item => item.dname)
        const money = data.map(item => item.revenue_total)
        const quantities = data.map(item => item.quantity)
        this.chartOptions.xAxis[0].data = names;
        this.chartOptions.series[0].data = money;
        this.chartOptions.series[1].data = quantities;
        this.$refs['statics'].refresh(this.chartOptions);
      },
      drawTable (res) {
        this.tableData = res.data
      },
      formatDate (date) {
        alert(date)
        month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
        year  = date.getFullYear()
        day = (date.getDate()) < 10 ? '0' + (date.getDate()) : (date.getDate())
        return year + '-' + month + '-' + day
      },
      refreshTable () {
        byRange(this.from, this.to).then(res => this.drawTable(res))
      },
      refresh () {
        let month, year, day, d
        if(Object.prototype.toString.call(this.date) === '[object Date]') {
          month = (this.date.getMonth() + 1) < 10 ? '0' + (this.date.getMonth() + 1) : (this.date.getMonth() + 1)
          year  = this.date.getFullYear()
          day = (this.date.getDate()) < 10 ? '0' + (this.date.getDate()) : (this.date.getDate())
        } else {
          const date = this.date.split("-")
          year = date[0]
          month = date[1]
          day = date[2]
        }
        switch (parseInt(this.type)){
          case 1:
            today().then(res => this.assignData(res))
            d = year + '-' + month + '-' + day
            this.from = d
            this.to = d
            byRange(d, d).then(res => this.drawTable(res))
            break;
          case 2:
            byMonth(year + '-' + month).then(res => {
              this.assignData(res)
            } )
            byRange(year+ '-' + month + '-01', year+ '-' + month + '-31').then(res => this.drawTable(res))
            this.from = year+ '-' + month + '-01'
            this.to =  year+ '-' + month + '-31'
            break;
          case 3:
            byYear(year).then(res => this.assignData(res))
            byRange(year + '-01-01', year + '-12-31').then(res => this.drawTable(res))
            this.from = year + '-01-01'
            this.to =  year + '-12-31'
            break;
          case 4:
            d = year + '-' + month + '-' + day
            byDay(d).then(res => this.assignData(res))
            byRange(d, d).then(res => this.drawTable(res))
            this.from = d
            this.to = d
            break;
          default:
            today().then(res => this.assignData(res))
            break;
        }
      },
      showDetail (date) {
        this.type = 4
        this.date = date
      }
    }
  }
</script>

<style scoped>

</style>
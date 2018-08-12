<template lang="pug">
  el-card(class="box-card")
    div(slot="header" class="clearfix" style="text-align: left")
      el-row(:gutter="10")
        el-col(:span="12")
          svg-icon(icon-class="fa-solid chart-bar")
          span(style="margin-left: 10px;") Thống kê sản phẩm được mua
        el-col(:span="type == 1 ? 12 : 8")
          div(style="text-align: right;")
            el-radio-group(v-model="type" size="mini")
              el-radio-button(label="1") Hôm nay
              el-radio-button(label="2") Theo tháng
              el-radio-button(label="3") Theo năm
        el-col(:span="4" v-show="type == 2 || type == 3")
          el-date-picker(
            :type="type == 3 ? 'year' : 'month'"
            :format="type == 3 ? 'yyyy' : 'yyyy-MM'"
            :value-format="type == 3 ? 'yyyy' : 'yyyy-MM'"
            v-model="date" size="mini" style="width: 100%;")
    div
      chart(:options="chartOptions" ref="statics" size="mini")
</template>

<script>
  import Chart from '~/components/Chart/BarChart';
  import {today, byMonth, byYear} from '~/api/client'
  import ElCard from "element-ui/packages/card/src/main";
  export default {
    name: 'Statics',
    components: {
      ElCard,
      Chart
    },
    data () {
      return {
        type: 1,
        date: new Date,
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
      today().then(res => this.assignData(res))
    },
    watch: {
      type: 'refresh',
      date: 'refresh'
    },
    methods: {
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
      refresh () {
        let month
        let year
        if(Object.prototype.toString.call(this.date) === '[object Date]') {
          month = (this.date.getMonth() + 1) < 10 ? '0' + (this.date.getMonth() + 1) : (this.date.getMonth() + 1)
          year  = this.date.getFullYear()
        } else {
          const date = this.date.split("-")
          year = date[0]
          month = date[1]
        }
        switch (parseInt(this.type)){
          case 1:
            today().then(res => this.assignData(res))
            break;
          case 2:
            byMonth(year + '-' + month).then(res => {
              console.log(res)
              this.assignData(res)
            } )
            break;
          case 3:
            byYear(year).then(res => this.assignData(res))
            break;
          default:
            today().then(res => this.assignData(res))
            break;
        }
      }
    }
  }
</script>

<style scoped>

</style>
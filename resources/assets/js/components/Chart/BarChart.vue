<template>
  <div :class="className" :style="{height:height,width:width}"></div>
</template>

<script>
import echarts from 'echarts'
require('echarts/theme/macarons') // echarts theme
import { debounce } from '~/utils'

const animationDuration = 100

export default {
  props: {
    className: {
      type: String,
      default: 'chart'
    },
    width: {
      type: String,
      default: '100%'
    },
    height: {
      type: String,
      default: '300px'
    }
  },
  data() {
    return {
      chart: null
    }
  },
  mounted() {
    this.initChart()
    this.__resizeHanlder = debounce(() => {
      if (this.chart) {
        this.chart.resize()
      }
    }, 100)
    window.addEventListener('resize', this.__resizeHanlder)
  },
  beforeDestroy() {
    if (!this.chart) {
      return
    }
    window.removeEventListener('resize', this.__resizeHanlder)
    this.chart.dispose()
    this.chart = null
  },
  methods: {
    initChart() {
      this.chart = echarts.init(this.$el, 'macarons')

      this.chart.setOption({
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
          data:['Bar', 'Line']
        },
        xAxis: [{
          type: 'category',
          data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
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
          name:'Bar',
          type:'bar',
          barWidth: '40%',
          data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 200, 32.6, 20.0, 6.4, 3.3]
        }, {
          name:'Line',
          type:'line',
          yAxisIndex: 0,
          data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 200, 32.6, 20.0, 6.4, 3.3]
        }]
      })
    }
  }
}
</script>

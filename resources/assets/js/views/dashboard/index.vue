<template lang="pug">
  div.dashboard-container
    el-row
      el-col(:xs="24" :sm="12" :lg="12" style="padding-right: 5px")
        el-card
          div.clearfix(slot="header")
            span
              svg-icon(icon-class="fa-solid chart-bar")
              span(style="margin-left: 10px;") DOANH THU THEO TUẦN
          div
            bar-chart
      el-col(:xs="24" :sm="12" :lg="12" style="padding-left: 5px")
        el-card
          div.clearfix(slot="header")
            span
              svg-icon(icon-class="fa-solid chart-bar")
              span(style="margin-left: 10px;") DOANH THU THEO THÁNG
          div
            bar-chart
    div.clearfix(style="margin: 10px 0;")
    el-row
      el-col(:span="24")
        el-card
          div.clearfix(slot="header")
            span
              svg-icon(icon-class="fa-solid user-graduate")
              span(style="margin-left: 10px;") NHÂN VIÊN XUẤT SẮC
          div

    div.clearfix(style="margin: 10px 0;")
    el-row
      el-col(:span="24")
        el-card
          div.clearfix(slot="header")
            span
              svg-icon(icon-class="fa-solid shipping-fast")
              span(style="margin-left: 10px;") SẢN PHẨM BÁN CHẠY
          div

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import BarChart from './BarChart';

export default {
  name: 'dashboard',
  computed: {
    ...mapGetters({

    })
  },
  methods: {
    ...mapActions({
    })
  },
  components: {
    BarChart
  },
  created () {

  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>

.dashboard {
  &-text {
    font-size: 20px;
    line-height: 46px;
  }
}
</style>
<style rel="stylesheet/scss" lang="scss">
.media-modal {
  .el-dialog__header {
    display: none;
  }

  .el-dialog__body {
    padding: 0;
  }
}
#product {
  .el-table th {
    background-color: darkgreen !important;
  }
}
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
<template lang="pug">
  div.dashboard-container
    el-row
      el-col(:xs="24" :sm="24" :lg="24")
        month-revenue-reports
    div.clearfix(style="margin: 15px 0;")
    el-row
      el-col(:xs="24" :sm="24" :lg="24")
        year-revenue-reports

    div.clearfix(style="margin: 15px 0;")
    el-row
      el-col(:xs="24" :sm="24" :lg="24")
        excellent-employees

    div.clearfix(style="margin: 15px 0;")
    el-row
      el-col(:xs="24" :sm="24" :lg="24")
        sold-well-products

</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import MonthRevenueReports from '~/views/pages/report/MonthRevenueReports';
import YearRevenueReports from '~/views/pages/report/YearRevenueReports';
import ExcellentEmployees from '~/views/pages/report/ExcellentEmployees';
import SoldWellProducts from '~/views/pages/report/SoldWellProducts';

export default {
  name: 'dashboard',
  components: {
    MonthRevenueReports,
    YearRevenueReports,
    ExcellentEmployees,
    SoldWellProducts
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
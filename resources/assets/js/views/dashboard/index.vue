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
            employee-table(:employees="employees" :total="total")
    div.clearfix(style="margin: 10px 0;")
    el-row
      el-col(:span="24")
        el-card
          div.clearfix(slot="header")
            span
              svg-icon(icon-class="fa-solid shipping-fast")
              span(style="margin-left: 10px;") SẢN PHẨM BÁN CHẠY
          div
            product-table
</template>

<script>
import { mapGetters } from 'vuex'
import MediaManagerModal from '~/components/MediaManager/modal';
import AdministrativeSelect from '~/components/AdministrativeSelect';
import BarChart from './BarChart'
import ElCard from "element-ui/packages/card/src/main";
import EmployeeTable from '../pages/employees/components/Table'
import ProductTable from '../pages/products/components/ProductTable'
export default {
  name: 'dashboard',
  computed: {
    ...mapGetters([
      'name',
      'roles'
    ]),
    ...mapGetters('employee', {
      employees: 'list'
    }),
    total () {
      return this.employees.length
    }
  },
  components: {
    ElCard,
    MediaManagerModal,
    AdministrativeSelect,
    BarChart,
    EmployeeTable,
    ProductTable
  },
  data() {
    return {
      selectedProvince: {},
      mediaDialogVisible: false,
      selectedImageUrl: 'abc',
      tableData: [{
        stt: '1',
        name: 'SẢN PHẨM 1',
        phone: '01687767557',
        total: '600.000',
        totalPrice: '900.000'
      },{
          stt: '2',
          name: 'SẢN PHẨM 1',
          phone: '01687767557',
          total: '600.000',
          totalPrice: '900.000'
      }, {
          stt: '3',
          name: 'SẢN PHẨM 1',
          phone: '01687767557',
          total: '600.000',
          totalPrice: '900.000'
      }, {
          stt: '4',
          name: 'SẢN PHẨM 1',
          phone: '01687767557',
          total: '600.000',
          totalPrice: '900.000'
      }, {
          stt: '5',
          name: 'SẢN PHẨM 1',
          phone: '01687767557',
          total: '600.000',
          totalPrice: '900.000'
      }
      ]
    }
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
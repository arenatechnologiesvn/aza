<template lang="pug">
  div.dashboard-container
    el-row
      el-col(:xs="24" :sm="24" :lg="8")
        div.chart-wrapper
          bar-chart
</template>

<script>
import { mapGetters } from 'vuex'
import MediaManagerModal from '~/components/MediaManager/modal';
import AdministrativeSelect from '~/components/AdministrativeSelect';
import BarChart from './BarChart'

export default {
  name: 'dashboard',
  computed: {
    ...mapGetters([
      'name',
      'roles'
    ])
  },
  components: {
    MediaManagerModal,
    AdministrativeSelect,
    BarChart
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
  &-container {
    margin: 30px;
  }
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
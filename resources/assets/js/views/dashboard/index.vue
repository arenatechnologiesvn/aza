<template>
  <div class="dashboard-container">

    <el-button type="primary" @click="$refs.media_manager_modal.dialogVisible = true">Open Media Manager</el-button>
    <media-manager-modal ref="media_manager_modal"></media-manager-modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import MediaManagerModal from '~/components/MediaManager/modal'

export default {
  name: 'dashboard',
  computed: {
    ...mapGetters([
      'name',
      'roles'
    ])
  },
  components: {
    MediaManagerModal
  },
  data() {
    return {
      mediaDialogVisible: false,
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
</style>

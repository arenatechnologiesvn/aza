<template>
  <div class="dashboard-container">
    <div class="dashboard-text">SẢN PHẨM BÁN CHẠY</div>
    <el-table
            id="product"
            :data="tableData"
            :border="true"
            style="width: 100%">
      <el-table-column
              prop="stt"
              label="STT"
              width="80">
      </el-table-column>
      <el-table-column
              prop="name"
              label="Tên sản phẩm"
              width="200">
      </el-table-column>
      <el-table-column
              prop="category"
              label="Danh mục">
      </el-table-column>
      <el-table-column
              prop="company"
              label="Nhà cung cấp">
      </el-table-column>
      <el-table-column
              prop="price"
              label="Giá">
      </el-table-column>
      <el-table-column
              prop="total"
              label="Tổng đơn hàng">
      </el-table-column>
      <el-table-column
              prop="totalPrice"
              label="Tổng cộng">
      </el-table-column>
    </el-table>
    <br>
    <div class="dashboard-text">NHÂN VIÊN XUẤT SẮC</div>
    <el-table
            :data="tableData"
            :border="true"
            style="width: 100%">
      <el-table-column
              prop="stt"
              label="STT"
              width="80">
      </el-table-column>
      <el-table-column
              prop="name"
              label="Họ tên"
              width="200">
      </el-table-column>
      <el-table-column
              prop="phone"
              label="Điện Thoại">
      </el-table-column>
      <el-table-column
              prop="total"
              label="Tổng đơn hàng">
      </el-table-column>
      <el-table-column
              prop="totalPrice"
              label="Tổng cộng">
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'dashboard',
  computed: {
    ...mapGetters([
      'name',
      'roles'
    ])
  },
  data() {
    return {
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
  #product {
    .el-table th {
      background-color: darkgreen !important;
    }
  }
</style>

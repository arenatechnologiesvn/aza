<template lang="pug">
  div.form__container
    el-card
      div.clearfix(slot="header")
        span
          svg-icon(icon-class="fa-solid upload")
          span(style="margin-left: 10px;") Tải lên sản phẩm
      .app-container
        upload-excel-component(:on-success="handleSuccess" :before-upload="beforeUpload")
        .table__wrapper
          .index__container
            .table
              el-table(:data="tableData" border size="small" style="width: 100%; margin-top:20px;")
                el-table-column(v-for="item of tableHeader" :prop="item" :label="item" :key="item")
        //-         el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
        //-           template(slot-scope="scope")
        //-             el-tooltip(class="item" effect="dark" content="Sửa đổi" placement="top")
        //-               el-button(icon="el-icon-edit" size="mini" round  @click="openEditPanel(scope.row.id)")
        //-             el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
        //-               el-button(type="danger" icon="el-icon-delete" size="mini" round @click="deleteOneProduct(scope.row.id)")
        //-     div.pagination__wrapper
        //-       el-pagination(:current-page.sync="currentPage"
        //-         :page-sizes="[10, 20, 30, 50]"
        //-         :page-size="pageSize"
        //-         layout="total, sizes, prev, pager, next"
        //-         :total="totalDataNum"
        //-         @size-change="sizeChange")
        //- el-table(:data="tableData" border highlight-current-row style="width: 100%;margin-top:20px;")
        //-   el-table-column(v-for="item of tableHeader" :prop="item" :label="item" :key="item")

</template>tableHeader

<script>
import UploadExcelComponent from '~/components/UploadExcel/index.vue'
export default {
  name: 'UploadExcel',
  components: { UploadExcelComponent },
  data() {
    return {
      tableData: [],
      tableHeader: []
    }
  },
  methods: {
    beforeUpload(file) {
      const isLt1M = file.size / 1024 / 1024 < 1
      if (isLt1M) {
        return true
      }
      this.$message({
        message: 'File tải lên không được vượt quá 1M.',
        type: 'warning'
      })
      return false
    },
    handleSuccess({ results, header }) {
      this.tableData = results
      this.tableHeader = header
    }
  }
}
</script>
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
              el-table(:data="showingData" border size="small" style="width: 100%; margin-top:20px;")
                el-table-column(v-for="item of tableHeader" :prop="item" :label="item" :key="item")
                el-table-column(v-if="tableData.length" label="TÁC VỤ" width="125" fixed="right")
                  template(slot-scope="scope")
                    el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                      el-button(type="danger" icon="el-icon-delete" size="mini" round @click="removeProduct(scope.row)")
            div.pagination__wrapper(v-if="tableData.length")
              el-pagination(:current-page.sync="currentPage"
                :page-sizes="[10, 20, 30, 50]"
                :page-size="pageSize"
                layout="total, sizes, prev, pager, next"
                :total="totalDataNum"
                @size-change="sizeChange")

</template>tableHeader

<script>
import UploadExcelComponent from '~/components/UploadExcel/index.vue'

const DEDAULT_PAGE_SIZE = 10

export default {
  name: 'UploadExcel',
  components: { UploadExcelComponent },
  computed: {
    showingData() {
      return this.extractData(this.tableData)
    }
  },
  data() {
    return {
      tableData: [],
      tableHeader: [],
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
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
    },
    extractData(data) {
      this.totalDataNum = data.length;

      const results = [];
      const offset = (this.currentPage - 1) * this.pageSize;
      data.forEach((item, index, array) => {
        if (index < offset) return;
        if (index >= offset + this.pageSize) return;
        results.push(item);
      });

      return results;
    },
    sizeChange(newPageSize) {
      this.pageSize = newPageSize;
    },
    removeProduct(code) {
      console.log(code);
    }
  }
}
</script>
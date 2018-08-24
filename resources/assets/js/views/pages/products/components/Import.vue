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
                el-table-column(v-for="item of tableHeader" :prop="item" :label="tableHeaderLabels[item]" :key="item")
                el-table-column(v-if="tableData.length" label="TÁC VỤ" style="text-align: center")
                  template(slot-scope="scope")
                    el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                      el-button(type="danger" icon="el-icon-delete" size="mini" round @click="remove(scope.row.product_code)")
            div.pagination__wrapper(v-if="tableData.length")
              el-pagination(:current-page.sync="currentPage"
                :page-sizes="[10, 20, 30, 50]"
                :page-size="pageSize"
                layout="total, sizes, prev, pager, next"
                :total="totalDataNum"
                @size-change="sizeChange")
              el-row(type="flex" justify="end" style="text-align: right; margin: 10px 14px 0 0;")
        el-row(style="margin-top: 15px")
          el-col(:span="24" style="text-align: right")
            el-button(type="info" size="small" @click="cancel")
              svg-icon(icon-class="fa-solid ban")
              span(style="margin-left: 10px") Hủy bỏ
            el-button(type="primary" size="small" @click="save" :disabled="!tableData.length")
              svg-icon(icon-class="fa-solid save")
              span(style="margin-left: 10px") Lưu
</template>

<script>
import { mapActions } from 'vuex';
import UploadExcelComponent from '~/components/UploadExcel/index.vue';

const DEDAULT_PAGE_SIZE = 10

export default {
  name: 'UploadExcel',
  components: { UploadExcelComponent },
  computed: {
    tableData() {
      return this.extractData(this.uploadData)
    }
  },
  data() {
    return {
      uploadData: [],
      tableHeader: [],
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
    }
  },
  methods: {
    ...mapActions({
      importProducts: 'products/bulkCreate'
    }),

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
      this.uploadData = results
      this.tableHeader = header
      this.tableHeaderLabels = this.uploadData && this.uploadData[0]
    },

    extractData(data) {
      const results = [];
      const offset = (this.currentPage - 1) * this.pageSize;
      data.forEach((item, index, array) => {
        if (index === 0) return;
        if (index < offset) return;
        if (index >= offset + this.pageSize) return;
        results.push(item);
      });

      this.totalDataNum = results.length;
      return results;
    },

    sizeChange(newPageSize) {
      this.pageSize = newPageSize;
    },

    remove(code) {
      this.uploadData = this.uploadData.filter((item) => {
        return item.product_code !== code;
      });
    },

    save() {
      const params = this.tableData.map((item) => {
        return {
          product_code: item.product_code,
          name: item.name,
          price: item.price,
          unit: item.unit,
          quantitative: item.quantitative,
          category_code: item.category_code || '',
          provider_code: item.provider_code || '',
          note: item.note || ''
        };
      });

      if (this.isValidData(params)) {
        this.importProducts(params).then(() => {
          this.$router.push({ path: '/products' });
        }).catch(() => {
          // Do nothing
        });
      } else {
        this.$notify({
          title: 'Thông báo',
          message: 'Dữ liệu các cột có dấu (*) không được trống',
          type: 'error'
        })
      }
    },

    isValidData(params) {
      const invalidData = params.find((item) => {
        return !item.product_code ||
                !item.name ||
                !item.price ||
                !item.unit ||
                !item.quantitative
      });

      return !invalidData;
    },

    cancel() {
      this.$confirm('Bạn có muốn hủy tải lên những sản phẩm này?', 'Xác nhận', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Hủy',
        type: 'warning'
      }).then(() => {
        this.$router.push({ path: '/products' });
      }).catch(() => {
        // Do nothing
      });
    }
  }
}
</script>
<template lang="pug">
  div
    el-row.search-wrapper(:gutter="5")
      el-col(:span="16")
        span.search-wrapper__title Tìm kiếm:
        el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="width: 100%" size="small")
      el-col(:span="4")
        span.search-wrapper__title Danh mục:
        el-select(v-model="selectedCategory" @change="filterData" @clear="filterData" clearable placeholder="Danh mục" size="small" style="width: 100%")
          el-option(v-for="item in categories" :key="item.id" :label="item.name" :value="item.id")
            svg-icon(:icon-class="item.icon")
            span(style="margin-left: 5px") {{ item.name }}
      el-col(:span="4")
        span.search-wrapper__title Nhà cung cấp:
        el-select(v-model="selectedProvider" @change="filterData" @clear="filterData" clearable placeholder="Nhà cung cấp" size="small" style="width: 100%")
          el-option(v-for="item in providers" :key="item.id" :label="item.name" :value="item.id")
    .control-wrapper
      el-row
        //- el-col(:span="8")
          //- el-dropdown(split-button type="primary" size="small")
          //-   span Đã chọn {{ multipleSelection.length }} sản phẩm
          //-   el-dropdown-menu(slot="dropdown")
          //-     el-dropdown-item Xóa
        el-col(:span="24" style="text-align: right")
          el-button(type="success" size="small" @click="exportExcelFile" :disabled="!this.tableData.length")
            svg-icon(icon-class="fa-solid file-excel")
            span.ml-5  Xuất Excel
          el-button(type="success" size="small" @click="redirectToImportPage" v-if="enableImport")
            svg-icon(icon-class="fa-solid upload")
            span.ml-5  Tải lên
          el-button(type="primary" size="small" @click="redirectToAddingPage" v-if="enableAdd")
            svg-icon(icon-class="fa-solid plus-circle")
            span.ml-5  Thêm mới
    div.table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%" @selection-change="handleSelectionChange" v-loading="loading")
            //- el-table-column(type="selection" header-align="center" align="center" width="40")
            el-table-column(prop="num" label="STT" align="center" width="60")
              template(slot-scope="scope")
                span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
            el-table-column(prop="featured_image" align="center" width="60")
              template(slot-scope="scope")
                img(:src="featuredImageUrl(scope.row)" :width="40" :height="40")
            el-table-column(prop="product_code" label="MÃ SẢN PHẨM" sortable min-width="180")
            el-table-column(prop="name" label="TÊN SẢN PHẨM" sortable min-width="200")
            el-table-column(prop="price" label="GIÁ (VND)" align="right" sortable min-width="150")
              template(slot-scope="scope")
                span {{ Number(scope.row.price).toLocaleString('de-DE') }}
            el-table-column(prop="unit" label="ĐƠN VỊ" sortable min-width="100")
            el-table-column(prop="quantitative" label="ĐỊNH LƯỢNG" sortable min-width="150")
            el-table-column(prop="category_name" label="DANH MỤC" sortable min-width="150")
              template(slot-scope="scope")
                span {{ scope.row.category ? scope.row.category.name : '-' }}
            el-table-column(prop="provider_name" label="NHÀ CUNG CẤP" sortable min-width="150")
              template(slot-scope="scope")
                span {{ scope.row.provider ? scope.row.provider.name : '-' }}
            el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
              template(slot-scope="scope")
                el-tooltip(class="item" effect="dark" content="Sửa đổi" placement="top" v-if="enableEdit")
                  el-button(icon="el-icon-edit" size="mini" round  @click="openEditPanel(scope.row.id)")
                el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                  el-button(type="danger" icon="el-icon-delete" size="mini" round @click="deleteOneProduct(scope.row.id)")
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next"
            :total="totalDataNum"
            @size-change="sizeChange")

    edit-panel
    media-manager-modal(type="product")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import EditPanel from './EditPanel';
import MediaManagerModal from '~/components/MediaManager/modal';
import dummyImage from '~/assets/login_images/dummy-image.jpg';
import excelExport from '~/utils/excel/export2Excel.js';
import moment from 'moment';
import {checkPermission} from '~/utils/util'
import {ADD_PRODUCT, EDIT_PRODUCT, IMPORT_PRODUCT} from '~/utils/const'
const DEDAULT_PAGE_SIZE = 10;

export default {
  name: 'product-table',
  components: {
    EditPanel,
    MediaManagerModal
  },
  computed: {
    ...mapGetters({
      products: 'products/list',
      categories: 'categories/list',
      providers: 'providers/list',
      loading: 'products/isLoading'
    }),

    tableData() {
      return this.extractData(this.products);
    },
    enableAdd () {
      return checkPermission(ADD_PRODUCT, this.$store.getters.mpermissions)
    },
    enableEdit () {
      return checkPermission(EDIT_PRODUCT, this.$store.getters.mpermissions)
    },
    enableImport () {
      return checkPermission(IMPORT_PRODUCT, this.$store.getters.mpermissions)
    }
  },
  created() {
    this.fetchData();
  },
  data() {
    return {
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
      multipleSelection: [],
      searchWord: '',
      selectedCategory: '',
      selectedProvider: ''
    }
  },
  methods: {
    ...mapActions({
      fetchProducts: 'products/fetchList',
      fetchProduct: 'products/fetchSingle',
      deleteProduct: 'products/destroy',
      setEditProductId: 'common/setEditProductId',
      openProductEditPanel: 'common/openProductEditPanel'
    }),

    fetchData() {
      this.fetchProducts().catch(() => {
        // Do nothing
      });;
    },

    openEditPanel(productId) {
      this.fetchProduct({ id: productId }).then(() => {
        this.setEditProductId({ productId: productId });
        this.openProductEditPanel();
      }).catch((error) => {
        // Do nothing
      });
    },

    filterData(data) {
      const filterWord = this.searchWord && this.searchWord.toLowerCase();

      if (filterWord !== '') {
        filterWord.trim().split(/\s/).forEach(word => {
          data = Array.isArray(data) && data.filter(item => {
            return item.name.toLowerCase().indexOf(word) > -1;
          });
        });
      }

      if (this.selectedCategory) {
        data = Array.isArray(data) && data.filter(item => {
          return item.category_id && item.category_id.toString().trim() === this.selectedCategory.toString().trim();
        });
      }

      if (this.selectedProvider) {
        data = Array.isArray(data) && data.filter(item => {
          return item.provider_id && item.provider_id.toString().trim() === this.selectedProvider.toString().trim();
        });
      }

      return data;
    },

    extractData(data) {
      // Search data
      data = this.filterData(data);

      // Set total size before cutting for paging
      this.totalDataNum = data.length;

      // Paging and Adding Adsets
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

    handleSelectionChange(val) {
        this.multipleSelection = val;
    },

    redirectToAddingPage() {
      this.$router.push({path: '/products/create'});
    },

    redirectToImportPage() {
      this.$router.push({path: '/products/import'});
    },

    deleteOneProduct(productId) {
      this.$confirm('Bạn có chắc chắn muốn xóa sản phẩm này?', 'Xác nhận', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Hủy',
        type: 'warning'
      }).then(() => {
        this.deleteProduct({ id: productId }).then(() => {
          this.fetchData();
        });
      });
    },

    featuredImageUrl(row) {
      if (!row.featured_image) return dummyImage;
      return row.featured_image.url;
    },

    exportExcelFile() {
      const exportData = this.products.map((item, index) => {
        return {
          "STT": index + 1,
          "MÃ SẢN PHẨM": item.product_code,
          "TÊN SẢN PHẨM": item.name,
          "GIÁ (VND)": Number(item.price).toLocaleString('de-DE'),
          "ĐƠN VỊ": item.unit,
          "ĐỊNH LƯỢNG": item.quantitative,
          "DANH MỤC": item.category && item.category.name ? item.category.name : '-',
          "NHÀ CUNG CẤP": item.provider && item.provider.name ? item.provider.name : '-'
        };
      });
      excelExport(`DSSP_${moment().format('DDMMYYYY_hhmmss')}`, exportData).then(() => {
        // Do nothing
      }).catch(() => {
        // Do nothing
      });
    }
  }
}
</script>

<style lang="scss" scoped>
.control-wrapper {
  margin: 10px 0;
}

.search-wrapper {
  margin: 10px 0 20px;

  &__title {
    font-size: 12px;
  }
}
</style>

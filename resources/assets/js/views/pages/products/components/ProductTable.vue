<template lang="pug">
  div
    el-row.search-wrapper(:gutter="5")
      el-col(:span="16")
        span.search-wrapper__title Tìm kiếm:
        el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="width: 100%")
      el-col(:span="4")
        span.search-wrapper__title Danh mục:
        el-select(v-model="selectedCategory" @change="filterData" @clear="filterData" clearable placeholder="Danh mục")
          el-option(v-for="item in categories" :key="item.id" :label="item.name" :value="item.id")
            svg-icon(:icon-class="item.icon")
            span(style="margin-left: 5px") {{ item.name }}
      el-col(:span="4")
        span.search-wrapper__title Nhà cung cấp:
        el-select(v-model="selectedProvider" @change="filterData" @clear="filterData" clearable placeholder="Nhà cung cấp")
          el-option(v-for="item in providers" :key="item.id" :label="item.name" :value="item.id")
    .control-wrapper
      el-row
        el-col(:span="12")
          el-dropdown(split-button type="primary" size="small")
            span Đã chọn {{ multipleSelection.length }} sản phẩm
            el-dropdown-menu(slot="dropdown")
              el-dropdown-item Xóa
        el-col(:span="12" style="text-align: right")
          el-button(type="success" size="small")
            svg-icon(icon-class="fa-solid file-excel")
            span.ml-5  Xuất Excel
          el-button(type="primary" size="small" @click="redirectToAddingPage")
            svg-icon(icon-class="fa-solid plus-circle")
            span.ml-5  Thêm mới
    div.table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%" @selection-change="handleSelectionChange")
            el-table-column(type="selection" header-align="center" align="center" width="40")
            el-table-column(prop="preview_images" align="center" width="60")
              template(slot-scope="scope")
                img(:src="scope.row.preview_images" :width="40" :height="40")
            el-table-column(prop="name" label="TÊN SẢN PHẨM" sortable)
            el-table-column(prop="price" label="GIÁ (VND)" sortable width="180")
              template(slot-scope="scope")
                span {{ Number(scope.row.price).toLocaleString('de-DE') }}
            el-table-column(prop="unit" label="ĐƠN VỊ" sortable)
            el-table-column(prop="category_name" label="DANH MỤC" sortable)
              template(slot-scope="scope")
                span {{ scope.row.category_name || '-' }}
            el-table-column(prop="provider_name" label="NHÀ CUNG CẤP" sortable)
              template(slot-scope="scope")
                span {{ scope.row.provider_name || '-' }}
            el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
              template(slot-scope="scope")
                el-tooltip(class="item" effect="dark" content="Sửa đổi" placement="top")
                  el-button(icon="el-icon-edit" size="mini" round  @click="openEditPanel(scope.row.id)")
                el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                  el-button(type="danger" icon="el-icon-delete" size="mini" round @click="deleteOneProduct(scope.row.id)")
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="10"
            layout="total, sizes, prev, pager, next"
            :total="tableData.length")

    edit-panel
    media-manager-modal(type="product")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import EditPanel from './EditPanel';
import MediaManagerModal from '~/components/MediaManager/modal';

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
      providers: 'providers/list'
    })
  },
  created() {
    this.fetchData();
  },
  data() {
    return {
      tableData: [],
      currentPage: 1,
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
      this.fetchProducts().then(() => {
        this.tableData = JSON.parse(JSON.stringify(this.products));
      });
    },

    openEditPanel(productId) {
      this.fetchProduct({ id: productId }).then(() => {
        this.setEditProductId({ productId: productId });
        this.openProductEditPanel();
      });
    },

    filterData() {
      this.tableData = JSON.parse(JSON.stringify(this.products));
      const filterWord = this.searchWord && this.searchWord.toLowerCase();

      if (filterWord !== '') {
        filterWord.trim().split(/\s/).forEach(word => {
          this.tableData = this.tableData.filter(item => {
            return item.name.toLowerCase().indexOf(word) > -1;
          });
        });
      }

      if (this.selectedCategory) {
        this.tableData = this.tableData.filter(item => {
          return item.category_id === this.selectedCategory;
        });
      }

      if (this.selectedProvider) {
        this.tableData = this.tableData.filter(item => {
          return item.provider_id === this.selectedProvider;
        });
      }
    },

    handleSelectionChange(val) {
        this.multipleSelection = val;
    },

    redirectToAddingPage() {
      this.$router.push({path: '/products/add'});
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
    }
  },
  watch: {
    searchWord() {
      this.filterData();
    },

    products() {
      this.tableData = JSON.parse(JSON.stringify(this.products));
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

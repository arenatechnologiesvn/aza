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
            el-table-column(prop="featured_image" align="center" width="60")
              template(slot-scope="scope")
                img(:src="featuredImageUrl(scope.row)" :width="40" :height="40")
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
                el-tooltip(class="item" effect="dark" content="Sửa đổi" placement="top")
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
      providers: 'providers/list'
    }),

    tableData() {
      return this.extractData(this.products);
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
          data = data.filter(item => {
            return item.name.toLowerCase().indexOf(word) > -1;
          });
        });
      }

      if (this.selectedCategory) {
        data = data.filter(item => {
          return item.category_id === this.selectedCategory;
        });
      }

      if (this.selectedProvider) {
        data = data.filter(item => {
          return item.provider_id === this.selectedProvider;
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

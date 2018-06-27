<template lang="pug">
  div
    div.form-search__wrapper
      el-form.search
        el-row(:gutter="10")
          el-col(:span="16")
            el-form-item
              el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="width: 100%")
          el-col(:span="4")
            el-form-item
              el-select(v-model="selectedCategory" @change="filterData" @clear="filterData" clearable placeholder="Danh mục")
                el-option(v-for="item in categories" :key="item.id" :label="item.name" :value="item.id")
                  svg-icon(:icon-class="item.icon")
                  span(style="margin-left: 5px") {{ item.name }}
          el-col(:span="4")
            el-form-item
              el-select(v-model="selectedProvider" @change="filterData" @clear="filterData" clearable placeholder="Nhà cung cấp")
                el-option(v-for="item in providers" :key="item.id" :label="item.name" :value="item.id")
    div.control__wrapper
      el-row
        el-col(:span="12")
          h4.control__info(style="margin: 0;") Đã chọn {{ multipleSelection.length }} khách hàng
        el-col(:span="12" style="text-align: right;")
          el-button(type="success" size="small")
            svg-icon(icon-class="fa-solid file-excel")
            span.ml-5  Xuất Excel
          el-button(type="primary" size="small" @click="redirectToAddingPage")
            svg-icon(icon-class="fa-solid plus")
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
            el-table-column(prop="unit" label="ĐƠN VỊ" sortable)
            el-table-column(prop="category.name" label="DANH MỤC" sortable)
            el-table-column(prop="provider.name" label="NHÀ CUNG CẤP" sortable)
            el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
              template(slot-scope="scope")
                el-tooltip(class="item" effect="dark" content="Cập nhật" placement="top")
                  el-button(type="primary" icon="el-icon-edit" size="mini" round)
                el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                  el-button(type="danger" icon="el-icon-delete" size="mini" round)
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="20"
            layout="total, sizes, prev, pager, next"
            :total="tableData.length")
    el-dialog(title="Xác nhận xóa sản phẩm" :visible.sync="confirmDialogVisible" width="30%" center)
      el-row(type="flex" justify="center")
        span Bạn có chắc chắn muốn xóa sản phẩm này!
      span(slot="footer" class="dialog-footer")
        el-button(type="danger" @click="closeDeleteConfirmModal")
          svg-icon(icon-class="fa-solid ban")
          span  Hủy
        el-button(type="primary" @click="deleteOneProduct")
          svg-icon(icon-class="fa-solid check")
          span  Xác nhận
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';

export default {
  name: 'product-table',
  computed: {
    ...mapGetters('products', { products: 'list' }),
    ...mapGetters('categories', { categories: 'list' }),
    ...mapGetters('providers', { providers: 'list' }),
    ...mapState([
      'route', // vuex-router-sync
    ]),
    tableData() {
      return this.products;
    }
  },
  created() {
    this.fetchData();
  },
  data() {
    return {
      currentPage: 1,
      multipleSelection: [],
      searchWord: '',
      selectedCategory: '',
      selectedProvider: '',
      confirmDialogVisible: false,
      deleteProductId: ''
    }
  },
  methods: {
    ...mapActions(
      'products', { fetchProducts: 'fetchList' }
    ),

    ...mapActions(
      'categories', { fetchCategories: 'fetchList' }
    ),

    ...mapActions(
      'providers', { fetchProviders: 'fetchList' }
    ),

    fetchData() {
      this.fetchProductData();
      this.fetchCategoryData();
      this.fetchProviderData();
    },

    fetchProductData() {
      return this.fetchProducts();
    },

    fetchCategoryData() {
      return this.fetchCategories();
    },

    fetchProviderData() {
      return this.fetchProviders();
    },

    filterData() {
      this.tableData = this.products.slice();
      const filterWord = this.searchWord && this.searchWord.toLowerCase();

      if (filterWord !== '') {
        filterWord.trim().split(/\s/).forEach(word => {
          this.tableData = this.tableData.filter(item => {
            return item.name.indexOf(word) > 1;
          });
        });
      }

      if (this.selectedCategory) {
        this.tableData = this.tableData.filter(item => {
          return item.category && item.category.id === this.selectedCategory;
        });
      }

      if (this.selectedProvider) {
        this.tableData = this.tableData.filter(item => {
          return item.category && item.category.id === this.selectedProvider;
        });
      }
    },
    handleSelectionChange(val) {
        this.multipleSelection = val;
    },
    redirectToAddingPage() {
      this.$router.push({path: '/products/add'});
    },
    deleteOneProduct() {
      // openDeleteConfirmModal(scope.row.id)

      deleteProduct(this.deleteProductId).then(response => {
        this.products = response.data;
        
        // remove deleted item out of table data
        this.tableData = this.tableData.filter(item => {
          return item.id !== this.deleteProductId;
        }) || [];
        
        closeDeleteConfirmModal();     
      }).catch(error => {
        closeDeleteConfirmModal(); 
      });
    },
    openDeleteConfirmModal(id) {
      this.confirmDialogVisible = true;
      this.deleteProductId = id;
    },
    closeDeleteConfirmModal() {
      this.confirmDialogVisible = false;
      this.deleteProductId = '';
    }
  },
  watch: {
    searchWord() {
      this.filterData();
    },
    $route: 'fetchData'
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

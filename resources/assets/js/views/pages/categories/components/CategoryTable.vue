<template lang="pug">
  div
    .control__wrapper
      el-row
        el-col(:span="8")
          el-dropdown(split-button type="primary" size="small")
            span Đã chọn {{ multipleSelection.length }} danh mục
            el-dropdown-menu(slot="dropdown")
              el-dropdown-item Xóa
        el-col(:span="16" style="text-align: right")
          el-button(type="primary" size="small" @click="redirectToAddingPage")
            svg-icon(icon-class="fa-solid plus-circle")
            span.ml-5  Thêm mới
          el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="max-width: 200px; margin-left: 5px;" size="small")
    div.table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%" @selection-change="handleSelectionChange")
            el-table-column(type="selection" header-align="center" align="center" width="40")
            el-table-column(prop="icon" label="ICON" align="center" width="60")
              template(slot-scope="scope")
                svg-icon(:icon-class="scope.row.icon")
            el-table-column(prop="name" label="TÊN DANH MỤC" sortable)
            el-table-column(prop="description" label="MÔ TẢ" sortable)
              template(slot-scope="scope")
                span {{ scope.row.description || '-' }}
            el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
              template(slot-scope="scope")
                el-tooltip(class="item" effect="dark" content="Sửa đổi" placement="top")
                  el-button(icon="el-icon-edit" size="mini" round  @click="update(scope.row.id)")
                el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                  el-button(type="danger" icon="el-icon-delete" size="mini" round @click="deleteOneCategory(scope.row.id)")
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="10"
            layout="total, sizes, prev, pager, next"
            :total="tableData.length")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';

export default {
  name: 'category-table',
  computed: {
    ...mapGetters({
      categories: 'categories/list'
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
      searchWord: ''
    }
  },
  methods: {
    ...mapActions({
      fetchCategories: 'categories/fetchList',
      deleteCategory: 'categories/destroy'
    }),

    fetchData() {
      this.fetchCategories().then(() => {
        this.tableData = JSON.parse(JSON.stringify(this.categories));
      });
    },

    filterData() {
      this.tableData = JSON.parse(JSON.stringify(this.categories));
      const filterWord = this.searchWord && this.searchWord.toLowerCase();

      if (filterWord !== '') {
        filterWord.trim().split(/\s/).forEach(word => {
          this.tableData = this.tableData.filter(item => {
            return item.name.toLowerCase().indexOf(word) > -1;
          });
        });
      }
    },

    handleSelectionChange(val) {
        this.multipleSelection = val;
    },

    redirectToAddingPage() {
      this.$router.push({ path: '/products/category/create' });
    },

    update(categoryId) {
      this.$router.push({ path: `/products/category/${categoryId}` });
    },

    deleteOneCategory(categoryId) {
      this.$confirm('Bạn có chắc chắn muốn xóa danh mục này?', 'Xác nhận', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Hủy',
        type: 'warning'
      }).then(() => {
        this.deleteCategory({ id: categoryId }).then(() => {
          this.fetchData();
        });
      });
    }
  },
  watch: {
    searchWord() {
      this.filterData();
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

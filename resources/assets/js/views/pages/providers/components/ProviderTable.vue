<template lang="pug">
  div
    div.form-search__wrapper
      el-form.search
        el-row(:gutter="10")
          el-col(:span="12")
            el-form-item
              el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="width: 100%")
          el-col(:span="12")
            el-form-item
              administrative-select(v-model="selectedAdministrative")
    div.control__wrapper
      el-row
        el-col(:span="12")
          el-dropdown(split-button type="primary" size="small")
            span Đã chọn {{ multipleSelection.length }} nhà cung cấp
            el-dropdown-menu(slot="dropdown")
              el-dropdown-item Xóa
        el-col(:span="12" style="text-align: right;")
          el-button(type="primary" size="small" @click="redirectToAddingPage")
            svg-icon(icon-class="fa-solid plus-circle")
            span.ml-5  Thêm mới
    div.table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%" @selection-change="handleSelectionChange")
            el-table-column(type="selection" header-align="center" align="center" width="40")
            el-table-column(prop="name" label="TÊN" sortable)
            el-table-column(prop="phone" label="DI ĐỘNG" sortable)
            el-table-column(prop="home_phone" label="ĐIỆN THOẠI" sortable)
            el-table-column(prop="address" label="ĐỊA CHỈ" sortable)
            el-table-column(label="VÙNG" sortable)
              template(slot-scope="scope")
                span {{ administrativeConversion(scope.row) }}
            el-table-column(prop="contract_at" label="NGÀY HỢP ĐỒNG" sortable)
            el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
              template(slot-scope="scope")
                el-tooltip(class="item" effect="dark" content="Cập nhật" placement="top")
                  el-button(type="warning" icon="el-icon-edit" size="mini" round  @click="openEditPanel(scope.row.id)")
                el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                  el-button(type="danger" icon="el-icon-delete" size="mini" round @click="deleteOneProduct(scope.row.id)")
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="10"
            layout="total, sizes, prev, pager, next"
            :total="tableData.length")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import AdministrativeSelect from '~/components/AdministrativeSelect'

export default {
  name: 'provider-table',
  computed: {
    ...mapGetters({
      providers: 'providers/list'
    })
  },
  components: {
    AdministrativeSelect
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
      selectedAdministrative: {}
    }
  },
  methods: {
    ...mapActions({
      fetchProviders: 'providers/fetchList'
    }),

    fetchData() {
      this.fetchProviders().then(() => {
        this.tableData = JSON.parse(JSON.stringify(this.providers));
      });
    },

    // openEditPanel(productId) {
    //   this.fetchProduct({ id: productId }).then(() => {
    //     this.setEditProductId({ productId: productId });
    //     this.openProductEditPanel();
    //   });
    // },

    filterData() {
      this.tableData = JSON.parse(JSON.stringify(this.providers));
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
      this.$router.push({path: '/providers/add'});
    },

    deleteOneProduct(productId) {
      this.$confirm('Bạn có chắc chắn muốn xóa danh mục này?', 'Xác nhận', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Hủy',
        type: 'warning'
      }).then(() => {
        this.deleteProduct({ id: productId }).then(() => {
          this.fetchData();
        });
      });
    },

    administrativeConversion(provider) {
      if (provider.province && provider.district && provider.ward) {
        return `${provider.ward} - ${provider.district} - ${provider.province}`;
      }

      return '-';
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

<template lang="pug">
  div
    div.form-search__wrapper
      el-form.search
        el-row(:gutter="5")
          el-col(:span="12")
            el-form-item(label="Tìm kiếm:")
              el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="width: 100%")
          el-col(:span="4")
            el-form-item(label="Tỉnh/TP:")
              province-select(v-model="selectedProvince")
          el-col(:span="4")
            el-form-item(label="Huyện/Quận:")
              district-select(v-model="selectedDistrict" :parent-code="selectedProvince")
          el-col(:span="4")
            el-form-item(label="Xã/Phường:")
              ward-select(v-model="selectedWard" :parent-code="selectedDistrict")
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
            el-table-column(prop="name" label="TÊN" sortable min-width="200")
            el-table-column(prop="phone" label="DI ĐỘNG" sortable min-width="150")
            el-table-column(prop="home_phone" label="ĐIỆN THOẠI" sortable min-width="150")
            el-table-column(prop="address" label="ĐỊA CHỈ" sortable min-width="300")
            el-table-column(prop="zone" label="VÙNG" sortable min-width="300")
            el-table-column(prop="contract_at" label="NGÀY HỢP ĐỒNG" sortable min-width="200")
            el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
              template(slot-scope="scope")
                el-tooltip(class="item" effect="dark" content="Sửa đổi" placement="top")
                  el-button(icon="el-icon-edit" size="mini" round  @click="update(scope.row.id)")
                el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                  el-button(type="danger" icon="el-icon-delete" size="mini" round @click="deleteOneProvider(scope.row.id)")
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="10"
            layout="total, sizes, prev, pager, next"
            :total="tableData.length")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import ProvinceSelect from '~/components/AdministrativeSelect/Province';
import DistrictSelect from '~/components/AdministrativeSelect/District';
import WardSelect from '~/components/AdministrativeSelect/Ward';

export default {
  name: 'provider-table',
  computed: {
    ...mapGetters({
      providers: 'providers/list'
    })
  },
  components: {
    ProvinceSelect,
    DistrictSelect,
    WardSelect
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
      selectedProvince: '',
      selectedDistrict: '',
      selectedWard: ''
    }
  },
  methods: {
    ...mapActions({
      fetchProviders: 'providers/fetchList',
      deleteProvider: 'providers/destroy'
    }),

    fetchData() {
      this.fetchProviders().then(() => {
        this.tableData = JSON.parse(JSON.stringify(this.providers));
      });
    },

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
      this.$router.push({path: '/products/provider/create'});
    },

    update(providerId) {
      this.$router.push({path: `/products/provider/${providerId}`});
    },

    deleteOneProvider(providerId) {
      this.$confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?', 'Xác nhận', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Hủy',
        type: 'warning'
      }).then(() => {
        this.deleteProvider({ id: providerId }).then(() => {
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

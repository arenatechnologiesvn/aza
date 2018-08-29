<template lang="pug">
  div
    el-row.search-wrapper(:gutter="5")
      el-col(:span="12")
        span.search-wrapper__title Tìm kiếm:
        el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search"  size="small" style="width: 100%")
      el-col(:span="4")
        span.search-wrapper__title Tỉnh/TP:
        province-select(v-model="selectedProvince")
      el-col(:span="4")
        span.search-wrapper__title Huyện/Quận:
        district-select(v-model="selectedDistrict" :parent-code="selectedProvince")
      el-col(:span="4")
        span.search-wrapper__title Xã/Phường:
        ward-select(v-model="selectedWard" :parent-code="selectedDistrict")
    div.control__wrapper
      el-row
        //- el-col(:span="12")
        //-   el-dropdown(split-button :type="multipleSelection.length ? 'primary' : 'default'" size="small")
        //-     span Đã chọn {{ multipleSelection.length }} nhà cung cấp
        //-     el-dropdown-menu(slot="dropdown")
        //-       el-dropdown-item Xóa
        el-col(:span="24" style="text-align: right;")
          el-button(type="primary" size="small" @click="redirectToAddingPage")
            svg-icon(icon-class="fa-solid plus-circle")
            span.ml-5  Thêm mới
    div.table__wrapper
      div.index__container
        div.table
          el-table(:data="tableData" border size="small" style="width: 100%" @selection-change="handleSelectionChange")
            el-table-column(type="selection" header-align="center" align="center" width="40")
            el-table-column(prop="logo" align="center" width="60")
              template(slot-scope="scope")
                img(:src="logoUrl(scope.row)" :width="40" :height="40")
            el-table-column(prop="name" label="TÊN" sortable min-width="200")
            el-table-column(prop="phone" label="DI ĐỘNG" sortable min-width="150")
              template(slot-scope="scope")
                span {{ scope.row.phone || '-' }}
            el-table-column(prop="home_phone" label="ĐIỆN THOẠI" sortable min-width="150")
              template(slot-scope="scope")
                span {{ scope.row.home_phone || '-' }}
            el-table-column(prop="address" label="ĐỊA CHỈ" sortable min-width="300")
              template(slot-scope="scope")
                span {{ scope.row.address || '-' }}
            el-table-column(prop="zone" label="VÙNG" sortable min-width="300")
              template(slot-scope="scope")
                span {{ scope.row.zone || '-' }}
            el-table-column(prop="contract_at" label="NGÀY HỢP ĐỒNG" sortable min-width="200")
              template(slot-scope="scope")
                span {{ scope.row.contract_at || '-' }}
            el-table-column(prop="id" label="TÁC VỤ" width="125" fixed="right")
              template(slot-scope="scope")
                el-tooltip(class="item" effect="dark" content="Sửa đổi" placement="top")
                  el-button(icon="el-icon-edit" size="mini" round  @click="update(scope.row.id)")
                el-tooltip(class="item" effect="dark" content="Xóa" placement="top")
                  el-button(type="danger" icon="el-icon-delete" size="mini" round @click="deleteOneProvider(scope.row.id)")
        div.pagination__wrapper
          el-pagination(:current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next"
            :total="totalDataNum"
            @size-change="sizeChange")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import ProvinceSelect from '~/components/AdministrativeSelect/Province';
import DistrictSelect from '~/components/AdministrativeSelect/District';
import WardSelect from '~/components/AdministrativeSelect/Ward';
import dummyImage from '~/assets/login_images/dummy-image.jpg';

const DEDAULT_PAGE_SIZE = 10;

export default {
  name: 'provider-table',
  computed: {
    ...mapGetters({
      providers: 'providers/list'
    }),

    tableData() {
      return this.extractData(this.providers);
    }
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
      currentPage: 1,
      totalDataNum: 0,
      pageSize: DEDAULT_PAGE_SIZE,
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
      this.fetchProviders().catch(() => {
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

      if (this.selectedWard) {
        data = data.filter(item => {
          return item.ward_code === this.selectedWard;
        });
      } else if (this.selectedDistrict) {
        data = data.filter(item => {
          return item.district_code === this.selectedDistrict;
        });
      } else if (this.selectedProvince) {
        data = data.filter(item => {
          return item.province_code === this.selectedProvince;
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
    },

    logoUrl(row) {
      if (row.logo.length) return row.logo[0].url;
      return dummyImage;
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}

.search-wrapper {
  margin: 10px 0 20px;

  &__title {
    font-size: 12px;
  }
}
</style>

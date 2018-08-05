<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách cửa hàng

    el-row.search-wrapper(:gutter="5")
      el-col(:span="8")
        span.search-wrapper__title Tìm kiếm:
        el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" clearable size="small" style="width: 100%")
      el-col(:span="4")
        span.search-wrapper__title Khách hàng:
        el-select(placeholder="Khách hàng" v-model="selectedCustomer" clearable size="small")
          el-option(v-for="item in customerList" :key="item.id" :label="item.name" :value="item.id")
      el-col(:span="4")
        span.search-wrapper__title Tỉnh/TP:
        province-select(v-model="selectedProvince")
      el-col(:span="4")
        span.search-wrapper__title Huyện/Quận:
        district-select(v-model="selectedDistrict" :parent-code="selectedProvince")
      el-col(:span="4")
        span.search-wrapper__title Xã/Phường:
        ward-select(v-model="selectedWard" :parent-code="selectedDistrict")
    div.control__wraper
     aza-control(@on-add="handAddClick")
    div.index__wrapper
      aza-table(:shops="current" @on-update="handUpdateClick" :total="total" @on-delete="deleteHandle")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import ProvinceSelect from '~/components/AdministrativeSelect/Province';
  import DistrictSelect from '~/components/AdministrativeSelect/District'
  import WardSelect from '~/components/AdministrativeSelect/Ward'
  import BaseMixin from '../mixin'

  export default {
    name: 'ShopIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl,
      ProvinceSelect,
      DistrictSelect,
      WardSelect,
    },
    data () {
      return {
        selectedCustomer: '',
        searchWord: '',
        selectedProvince: '',
        selectedDistrict: '',
        selectedWard: ''
      }
    },
    computed: {
      ...mapGetters('customers', {
        customers: 'list'
      }),
      ...mapGetters('shops', {
        shops: 'list',
        isLoading: 'isLoading'
      }),
      ...mapGetters('administrative', {
        getZoneByProvince: 'getZoneByProvince',
        getZoneByDistrict: 'getZoneByDistrict',
        getZoneByWard: 'getZoneByWard'
      }),
      customerList () {
        return this.customers.map(item => {
          return {
            id: item.id,
            name: item.user.full_name
          }
        })
      },
      current () {
        return this.filterData(this.shops);
      },
      total () {
        this.current.length
      },
      ...mapState([
        'route'
      ])
    },
    watch: {
      $route : 'fetchData'
    },
    methods: {
      ...mapActions('shops', {
        fetchShops: 'fetchList',
        deleteSelection: 'deleteSelection',
        updateRole: 'update',
        destroy: 'destroy'
      }),
      ...mapActions('customers', {
        fetchCustomers: 'fetchList'
      }),
      changeStatusHandle (id, data) {
        this.updateRole({
          id: id,
          data: data
        })
      },
      fetchData() {
        return this.fetchShops()
      },
      handAddClick () {
        this.$router.push({
          name: 'shop_create'
        })
      },
      deleteHandle (shopId) {
        this.$confirm('Bạn muốn xóa cửa hàng này?', 'Xác nhận xóa cửa hàng', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy bỏ',
          type: 'warning',
          confirmButtonClass: 'el-button el-button--danger'
        }).then(() => {
          this.destroy({ id: shopId }).then(() => {
            this.$message({
              type: 'success',
              message: 'Xóa thành công cửa hàng'
            })
          })
        }).catch(() => {
          // Do nothing
        });
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'shop_update',
          params: {
            id
          }
        })
      },
      onSelected (selection) {
        this.selection = selection
      },
      onDeleteSelect (ids) {
        this.confirm(() => {
          this.deleteSelection({
            customUrl: 'deletes',
            data: {data: ids}
          }).then(() => {
            this.$message({
              type: 'success',
              message: `Xóa cừa hàng thành công`
            })
          })
        }, () => {
          this.$message({
            type: 'info',
            message: `Huy xóa cửa hàng`
          })
        })
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

        if (this.selectedCustomer) {
          data = data.filter(item => {
            return item.customer_id.toString().trim() === this.selectedCustomer.toString().trim();
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
    },
    created () {
      this.loading()
      this.fetchData()
      this.fetchCustomers()
    }
  }
</script>

<style lang="scss" scoped>
.search-wrapper {
  margin: 10px 0 20px;

  &__title {
    font-size: 12px;
  }
}
</style>
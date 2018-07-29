<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách cửa hàng
    div.search__wrapper(style="margin: 10px 0 20px")
      div.form-search__wrapper
        el-form.search
          el-row(style="margin: 0 -10px;")
            el-col(:span="12")
              el-form-item
                el-input(placeholder="Tìm kiếm" v-model="key" clearable suffix-icon="el-icon-search" style="width: 100%")
            el-col(:span="12")
              <!--administrative-select(v-model="search.location")-->
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Khách hàng" v-model="customer_id" clearable filterable)
                  el-option(v-for="item in customerList" :key="item.id" :label="item.value" :value="item.id")
    div.control__wraper
     aza-control(@on-add="handAddClick")
    div.index__wrapper
      aza-table(:shops="current" @on-update="handUpdateClick" :total="total" @on-delete="deleteHandle")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import AzaSearch from './components/FormSearch'
  import BaseMixin from '../mixin'
  import AdministrativeSelect from '~/components/AdministrativeSelect'
  export default {
    name: 'ShopIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl,
      AzaSearch,
      AdministrativeSelect
    },
    data () {
      return {
        key: '',
        customer_id: null
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
      customerList () {
        return this.customers.map(item => {
          return {
            id: item.id,
            value: item.user.full_name
          }
        })
      },
      current () {
        return this.shops
          .filter(item => item.name.indexOf(this.key) > -1)
          .filter(item => {
            if(this.customer_id === null || this.customer_id === '') return true;
            return item.customer.id === this.customer_id;
          })
      },
      total () {
        this.current.length
      },
      ...mapState([
        'route'
      ])
    },
    watch: {
      $route : 'fetchData',
      search: {
        handler(){
          this.fetchFind()
        },
        deep: true
      }
    },
    methods: {
      ...mapActions('shops', {
        fetchShops: 'fetchList',
        fetchSearch: 'search',
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
      fetchFind () {
        this.fetchSearch(this.search)
      },
      fetchData() {
        return this.fetchShops()
      },
      handAddClick () {
        this.$router.push({
          name: 'shop_create'
        })
      },
      deleteHandle (id) {
        this.$confirm('Bạn muốn xóa cửa hàng này?', 'Xác nhận xóa cửa hàng', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy bỏ',
          type: 'warning',
          confirmButtonClass: 'el-button el-button--danger'
        }).then(() => {
          this.destroy(id).then(() => {
            this.$message({
              type: 'success',
              message: `Xóa thành công cửa hàng - ${id}`
            })
          })
        }).catch(() => {
          this.$message({
            type: 'error',
            message: 'Hủy xóa thành công'
          });
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
      }
    },
    created () {
      this.loading()
      this.fetchData()
      this.fetchCustomers()
    }
  }
</script>
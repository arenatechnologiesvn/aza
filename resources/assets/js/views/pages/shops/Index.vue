<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách cửa hàng
    div.search__wrapper(style="margin: 10px 0 20px")
      shop-form-search
    div.control__wraper
      employee-control(@on-add="handAddClick")
    div.index__wrapper
      employee-table(:shops="shops" @on-update="handUpdateClick" :total="total")
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import EmployeeControl from './components/Control'
  import EmployeeTable from './components/Table'
  import ShopFormSearch from './components/FormSearch'
  export default {
    name: 'EmployeeIndex',
    components: {
      EmployeeControl,
      EmployeeTable,
      ShopFormSearch
    },
    computed: {
      ...mapGetters('shop', {
        shops: 'list'
      }),
      total () {
        return this.shops.length
      }
    },
    watch: {
      $route : 'getList'
    },
    methods: {
      ...mapActions('shop', {
        'getList': 'getList'
      }),
      handAddClick () {
        this.$router.push({
          name: 'shop_create'
        })
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'shop_update',
          params: {
            id
          }
        })
      }
    },
    created () {
      this.getList()
    }
  }
</script>

<style scoped>

</style>
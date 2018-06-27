<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách sản phẩm
      el-dropdown(style="float: right; padding-right: 5px; cursor: pointer;")
        span.el-dropdown-link
          svg-icon(icon-class="fa-solid cog")
          i(class="el-icon-arrow-down el-icon--right")
        el-dropdown-menu(slot="dropdown")
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid shopping-basket")
              span(style="margin-left: 5px;") Thêm mới cửa hàng
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid hand-pointer")
              span(style="margin-left: 5px;") Thêm mới loại khách hàng
    product-table
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex';
  import ProductTable from './components/ProductTable';

  export default {
    name: 'ProductIndex',
    components: {
      ProductTable
    },
    computed: {
      ...mapGetters(
        'categories', { categories: 'list'},
        'providers', { providers: 'list'}
      ),

      ...mapState([
        'route'
      ])
    },
    methods: {
      ...mapActions(
        'categories', { fetchCategories: 'fetchList' },
        'providers', { fetchProviders: 'fetchList' }
      ),

      fetchCategoryData() {
        this.fetchCategories().then(response => {
          this.categories = response;
        });
      },

      fetchProviderData() {
        return this.fetchProviders().then(response => {
          this.categories = response;
        });
      },

      fetchData() {
        this.fetchCategoryData();
        this.fetchProviderData();
      }
    },
    create() {
      this.fetchData();
    },
    watch: {
      $route: 'fetchData'
    }
  }
</script>

<style scoped>

</style>
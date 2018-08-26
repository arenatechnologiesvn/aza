<template lang="pug">
  div.form-search(style="float: right")
    span.form-group
      el-autocomplete.search(popper-class="my-autocomplete" v-model="search" :fetch-suggestions="querySearch" placeholder="Tìm kiếm danh mục, sản phẩm" @select="handleSelect")
        i(class="el-icon-search" slot="suffix")
        template(slot-scope="{ item }")
          div(class="value")
            el-col(:span="4")
              img(:src="item.image" height="30" width="30")
            el-col(:span="20")
              span {{ item.name }}
              span -
              span.price ₫{{ formatNumber(item.price) }}
    span.shopcart(style="color: black;")
      el-dropdown.top__dropdown(v-if="total > 0")
        el-badge(:value="total" class="item")
          router-link(to="/cart")
            svg-icon(icon-class="fa-solid shopping-cart")
        el-dropdown-menu(slot="dropdown")
          div(style="height: 300px; overflow-y: scroll;")
            table.cart-dropdown
              tbody
                tr(v-for="item in products" :key="item.id")
                  td(style="width: 20%")
                    img(:src="item.img" width="50" height="50")
                  td(style="width: 60%")
                    p(style="line-height: 20px;") {{item.title}}
                  td(style="width: 10%")
                    el-tag(type="danger" size="mini") {{item.quantity}}
                  td(style="width: 10%")
                    span.remove-item__cart(@click="removeFromCart(item.id)")
                      svg-icon(icon-class="fa-solid times")
          div
            tr(style="border-top: 1px solid red;")
              td(colspan="4")
                router-link(to="/cart" class="el-button el-button--success") Thanh Toán
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import _ from 'lodash'
  import {formatNumber} from '~/utils/util'
  export default {
    name: 'FormSearch',
    data () {
      return {
        search: ''
      }
    },
    computed: {
      ...mapGetters('cart', {
        data: 'list',
        cartData: 'cartProducts'
      }),
      ...mapGetters('products', {
        listProducts: 'list'
      }),
      total() {
        return this.data.length === 0 ? 0 :
          this.data.length
      },
      products() {
        return this.cartData()
      },
      searchProducts () {
        return this.listProducts.map(item => ({
          id: item.id,
          name: item.name,
          image:item.featured && item.featured[0] && `/${item.featured[0].directory}/${item.featured[0].filename}.${item.featured[0].extension}`,
          price: item.price
        }))
      }
    },
    methods: {
      ...mapActions('cart', {
        remove: 'destroy',
        fetchCart: 'fetchList'
      }),
      ...mapActions('products', {
        fetchProduct: 'fetchList'
      }),
      fetchData() {
        this.fetchCart()
      },
      removeFromCart(id) {
        this.canExecute('Bạn muốn xóa sản phẩm khỏi giỏ hàng')
          .then(() => this.remove({id}).then(() => {
            this.fetchProduct()
            this.fetchCart()
          }).then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã xóa thành công sản phẩm khỏi giỏ hàng',
              type: 'success'
            })))
      },
      querySearch(queryString, cb) {
        var links = this.searchProducts;
        var results = queryString ? links.filter(this.createFilter(queryString)) : links;
        // call callback function to return suggestion objects
        cb(results);
      },
      createFilter(queryString) {
        return (link) => {
          return (link.name.toLowerCase().indexOf(queryString.toLowerCase()) > -1);
        };
      },
      handleSelect (item) {
        this.$router.push({path: `/products/${item.id}`})
      },
      canExecute(message) {
        return new Promise(resolve => this.$confirm(message, 'Xác nhận', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          resolve(true);
        }));
      },
      formatNumber(num) {
        return formatNumber(num)
      }
    },
    created() {
      this.fetchData()
    }
  }
</script>

<style lang="scss" scoped>
  .cart-dropdown {
    width: 100%;
    max-width: 300px;
    max-height: 400px;
    overflow-y: scroll;
    tr {
      border-bottom: 1px solid #d6d6d6;
      vertical-align: middle;
      padding: 5px;
    }
    .remove-item__cart {
      cursor: pointer;
    }
  }
  .value {
    padding: 5px;
    span {
      line-height: 30px;
      vertical-align: middle;
      margin-left: 10px;
    }
    .price {
      color: darkred;
      font-weight: bolder;
    }
  }
  @media screen and (max-width: 500px) {
    .search {
      max-width: 150px;
      input {
        max-width: 150px;
      }
    }
  }
</style>
<style>
  .el-autocomplete-suggestion.el-popper.my-autocomplete {
    min-width: 300px !important;
  }
</style>

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
              span.price {{ formatNumber(item.price) }} ₫
    span.shopcart(style="color: black; cursor: pointer;")
      el-dropdown.top__dropdown(trigger="click")
        el-badge(:value="total" :hidden="total === 0" class="item")
          svg-icon.shopping-cart(icon-class="fa-solid shopping-cart")
        el-dropdown-menu(slot="dropdown")
          div.cart-dropdown-container
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
          div(style="padding: 10px 10px 0")
            el-row
              el-col(:span="24")
                router-link.el-button.el-button--success(to="/cart" style="width: 100%") THANH TOÁN
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
        return this.data && this.data.length ? this.data.length : 0;
      },
      products() {
        return this.cartData()
      },
      searchProducts () {
        return this.listProducts.map(item => ({
          id: item.id,
          name: item.name,
          image:item.featured && item.featured[0] && item.featured[0].url,
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
  .cart-dropdown-container {
    height: 300px;
    overflow-y: scroll;
  }
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

  .shopping-cart {
    font-size: 25px;
    vertical-align: middle;
    color: #2d3a4b;
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

<template lang="pug">
  div.account-favorite
    h4.account-favorite__title
      svg-icon(icon-class="fa-solid heart")
      template SẢN PHẨM YÊU THÍCH
    div.h-line
    div.account-favorite__content
      el-table(:data="favorites" style="width: 100%" border :show-header="false" v-loading="loading" size="mini")
        el-table-column
          template(slot-scope="scope")
            el-row.item(:gutter="10")
              el-col(:span="6")
                img(:src="scope.row.img")
              el-col(:span="18")
                h4 {{scope.row.title}}
                div
                  span(v-for="item in 5" :key="item" :style="{color: item <= 5 ? '#F7CA51': 'black'}")
                    svg-icon(icon-class="fa-solid star")
                div
                  span(@click="removeFromFavorite(scope.row.id)" style="cursor: pointer;")
                    svg-icon(icon-class="fa-solid trash")
        el-table-column(width="230" style="text-align: left;")
          template(slot-scope="scope")
            div(style="text-align: left;" v-if="scope.row.discount")
              div.price ₫{{formatNumber(scope.row.discount)}} / {{`${scope.row.quantitative} ${scope.row.unit}`}}
              div.discount ₫{{formatNumber(scope.row.price)}}
                span(style="margin-left: 10px; text-decoration: unset; color: black;")  {{ ((1 - (scope.row.discount / scope.row.price)) * 100).toFixed(2)}} %
            div(v-else)
              div.price ₫{{formatNumber(scope.row.price)}} / {{`${scope.row.quantitative} ${scope.row.unit}`}}
        el-table-column(prop="address" label="Date" width="100")
          template(slot-scope="scope")
            el-button(size="mini" type="warning" @click="addToCart(scope.row)")
              svg-icon(icon-class="fa-solid cart-plus")
    div(style="text-align: right; margin: 10px 0; padding: 10px;" v-show="!loading")
      el-button(type="primary" @click="addAllFavorite")
        svg-icon(icon-class="fa-solid cart-plus")
        span(style="margin-left: 10px;") Thêm tất cả vào giò hàng
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import {formatNumber} from '~/utils/util'
  import request from '~/utils/request'

  export default {
    name: 'AccountAlert',
    computed: {
      ...mapGetters('favorite', {
        favorites: 'favoriteProducts',
        loading: 'isLoading'
      })
    },
    watch: {
      $route: 'fetchData'
    },
    methods: {
      ...mapActions('favorite', {
        fetchFavorite: 'fetchList',
        deleteFavorite: 'destroy'
      }),
      ...mapActions('cart', {
        fetchCart: 'fetchList',
        add2Cart: 'create',
        updateCart: 'update'
      }),
      ...mapActions('products', {
        fetchProduct: 'fetchList'
      }),
      addToCart(product) {
        console.log(product)
        if (product.added) {
          this.canExecute('Bạn muốn thêm sản phẩm này vào giỏ hàng?')
            .then(() => {
              const data = {
                product_id: product.id,
                quantity: this.$store.state.cart.entities[product.id].quantity + 1,
                customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
              }
              this.updateCart({
                id: product.id,
                data: data
              })
            }).then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã thêm thành công sản phẩm vào giỏ hàng',
              type: 'success'
            }))
        } else {
          const customer_id = this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          this.canExecute('Bạn muốn thêm sản phẩm này vào giỏ hàng?')
            .then(() => {
              this.add2Cart({
                data: {
                  product_id: product.id,
                  quantity: 1,
                  customer_id
                }
              }).then(() => {
                this.fetchCart()
                this.fetchProduct()
              }).then(() => this.$notify(
                {
                  title: 'Thông báo',
                  message: 'Đã thêm thành công sản phẩm vào giỏ hàng',
                  type: 'success'
                }))
                .catch(err => console.log(err))
            })
        }
      },
      removeFromFavorite(id) {
        this.canExecute('Bạn muốn xóa sản phẩm khỏi danh sách yêu thích?')
          .then(() => {
            this.deleteFavorite({id})
          }).then(() => {
          this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã xóa thành công sản phẩm khỏi danh sách',
              type: 'success'
            })
        })

      },
      addAllFavorite () {
        this.canExecute().then(res => {
          const favorites = this.$store.state.favorite.list
          const carts = this.$store.state.cart.list
          const customer_id = this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          let tmp = [];
          for(let i = 0; i< favorites.length; i++) {
            if(carts.indexOf(favorites[i]) < 0) tmp.push({customer_id, product_id: parseInt(favorites[i]) , quantity: 1})
          }
          request({
            url: `/api/carts/save-all`,
            method: 'post',
            data: tmp
          }).then(data => {
            this.$message(
            {
              message: 'Đã thêm danh sách yêu thích vào giỏ hàng',
              type: 'success'
            })
            this.fetchProduct()
            this.fetchCart()
            this.$router.push({path: '/cart'})
          })
          .catch(err => {
            console.log(err)
            this.$message(
            {
              message: 'Lỗi khi thêm vào giỏ hàng',
              type: 'error'
            })
          })
        })
      },
      fetchData() {
        this.fetchFavorite();
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      canExecute(message) {
        return new Promise(resolve => this.$confirm(message, 'Xác nhận', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          resolve(true);
        }));
      }
    },
    created() {
      this.fetchData()
    }
  }
</script>

<style lang="scss" scoped>
  .account-favorite {
    background-color: white;
    .price {
      color: darkred;
      font-size: 18px;
    }
    .discount {
      color: #d6d6d6;
      text-decoration: line-through;
      font-size: 16px;
    }
    .item {
      text-align: left;
      img {
        width: 100%;
        height: 100px;
        object-fit: cover;
      }
      h4 {
        margin: 0;
        word-break: keep-all;
      }
    }
    img {
      border-radius: unset;
    }
    .h-line {
      display: block;
      margin: 5px 0;
      height: 1px;
      background-color: #eee;
    }
    .account-favorite__title {
      margin: 0;
      text-align: left;
      padding: 10px 15px;
      svg {
        margin-right: 10px;
      }
    }
  }
</style>
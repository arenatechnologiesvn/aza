<template lang="pug">
  el-card.product-item(class="box-card")
    div.card__contain
      div.product-item__image
        div(v-if="product.added").label ĐÃ THÊM VÀO GIỎ HÀNG
        div(v-if="product.inventory <= 0").label.no HẾT HÀNG
        img(:src="product.img")
      div.product-item__des
        div.product-item__title
          router-link(:to="`/home/products/${product.id}`") {{product.title}}
        div.product-item__description(style="color: black;")
          router-link(to="/home/products" style="font-size: 1.1em;") {{product.category}}
          p.description {{product.description}}
        div.line
        div.product-item__control
          div.product-item__control--left
            span.product-item__price {{formatNumber(product.price) + ' VNĐ'}}
            span.product-item__price--discount {{formatNumber(product.discount) + ' VNĐ'}}
          div.product-item__control--right
            span.heart(@click="toggleFavorite(product)" :style="{color: product.favorite ? 'red': 'black'}")
              svg-icon( icon-class="fa-solid heart")
            span.shop(@click="addToCart(product)")
              svg-icon(icon-class="fa-solid cart-plus")
</template>

<script>
  import { mapActions } from 'vuex'
  import { formatNumber } from '~/utils/util'
  export default {
    name: 'ItemProduct',
    props: {
      product: {
        type: Object,
        default: () => {}
      }
    },
    methods: {
      ...mapActions('cart', {
        add2Cart: 'create',
        updateCart: 'update'
      }),
      addToCart (product) {
        if (product.added) {
          const data = {
            product_id: product.id,
            quantity: parseInt(product.quantity) + 1,
            customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          }
          console.log(data)
          this.updateCart({
            id: product.id,
            data: data
          })
        } else {
          this.add2Cart({
            data: {
              product_id: product.id,
              quantity: 1,
              customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
            }
          }).then(res => console.log(res))
            .catch(err =>  console.log(err))
        }
      },
      toggleFavorite (product) {
        if (product.favorite) {
          this.removeProductFromFavorite(product.id)
        } else {
          this.addProductToFavorite(product.id)
        }
      },
      removeProductFromFavorite (id) {
        this.$store.dispatch('favorite/removeFromFavorite', id)
      },
      addProductToFavorite (id) {
        if (this.$store.state.favorite.items.length > 5){
          this.$notify({
            title: 'Cảnh báo giới hạn',
            message: 'Danh sách yêu thích đã vượt quá số lượng cho phép',
            type: 'warning'
          });
        } else {
          this.$store.dispatch('favorite/addProductToFavorite', id)
        }
      },
      formatNumber (num) {
        return formatNumber(num)
      }
    }
  }
</script>
<style lang="scss" scoped>
  .product-item {
    position: relative;
  }
  .label {
    position: absolute;
    width: 100%;
    height: 40px;
    line-height: 40px;
    vertical-align: middle;
    font-size: 14px;
    background-color: rgba(255,255,255,0.7);
    box-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    top: 0;
    left: 0;
    color: darkgreen;
    font-weight: bolder;
    text-align: left;
    padding-left: 5px;
    z-index: 999999;
    &.no {
      top: calc(50% - 20px);
      text-align: center;
      color: red;
    }
  }
  .description {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 100%;
  }
</style>
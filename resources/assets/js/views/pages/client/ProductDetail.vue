<template lang="pug">
  div.product-detail__container
    div.container
      bread-crumb
      div.product-detail__content
        el-row(:gutter="20")
          el-col(:span="8")
            preview-image
          el-col(:span="16")
            el-row.product-detail__title(type="flex")
              el-col(:span="20").left
                h4.title {{product.title}}
                span.category
                  strong Danh mục:
                  span.category__name {{product.category}}
                span.rating
                  span.score(v-for="item in 5" @click="rate(item)" :key="item" :style="{color: item <= rating ? 'orange' : ''}")
                    svg-icon(icon-class="fa-solid star")
              el-col(:span="4").right(style="text-align: right;")
                span.controls
                  el-button(size="mini")
                    svg-icon(icon-class="fa-solid angle-left")
                  el-button(size="mini")
                    svg-icon(icon-class="fa-solid angle-right")
            el-row(:span="24")
              p.description {{product.description}}
              div.price {{formatNumber(product.price)}} (VNĐ)
                span(style="margin-left: 20px; font-size=18px; color: #d6d6d6; text-decoration: line-through;") {{ formatNumber(product.discount)}} (VNĐ)
              div.submit
                span
                  el-button(type="success" @click="addToCart(product)" :disabled="product.added")
                    span(style="margin-right: 10px;")
                      svg-icon(icon-class="fa-solid cart-plus")
                    template Thêm vào giỏ hàng
        el-row.content
          el-col(:span="24")
            h4.content__title MÔ TẢ CHI TIẾT
            p {{product.description}}
        el-row.comment
          el-col(:span="24")
            el-button(:type="commentShow? 'default' : 'primary'" size="mini" @click="commentShow = !commentShow") {{commentShow ? 'X Hủy' : 'Gửi đánh giá của bạn về sản phẩm'}}
          el-col(:span="24")
            comment(v-if="commentShow")
      div.product-detail__relative
        h4 SẢN PHẨM LIÊN QUAN
        div
          // products(:control="false" :items="1")
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import PreviewImage from './components/PreviewImage'
  import Products from './components/products'
  import Comment from './components/Comment'
  import { mapGetters, mapActions } from 'vuex'
  import { formatNumber } from '~/utils/util'

  export default {
    name: 'ProductDetail',
    components: {
      BreadCrumb,
      PreviewImage,
      Products,
      Comment
    },
    computed: {
      ...mapGetters('products', {
        data: 'byId'
      }),
      product () {
        const item = this.data(this.$route.params.id)
        return item ? {
          id: item.id,
          title: item.name,
          img: item.featured && `/${item.featured[0].directory}/${item.featured[0].filename}.${item.featured[0].extension}` ,
          category: item.category ? item.category.name : 'Chưa xác định',
          price: item.price,
          discount: item.discount_price || item.price,
          inventory: 10,
          added: item.customer_carts && item.customer_carts.length > 0,
          favorite: item.customer_favorites && item.customer_favorites.length > 0,
          description: item.description
        }: {}
      }
    },
    data () {
      return {
        rating: 5,
        commentShow: false
      }
    },
    watch: {
      $route: 'getById'
    },
    methods: {
      ...mapActions('products', {
        fetchData : 'fetchSingle'
      }),
      ...mapActions('cart', {
        add2Cart: 'create',
        updateCart: 'update'
      }),
      rate (score) {
        this.rating = score
      },
      getById () {
        this.fetchData({
          id: this.$route.params.id
        })
      },
      formatNumber (num) {
        return formatNumber(num)
      },
      addToCart (product) {
        console.log(product)
        if (product.added) {
          const data = {
            product_id: product.id,
            quantity: this.$store.state.cart.entities[product.id].quantity + 1,
            customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          }
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
          }).then(res => {
            this.fetchCart()
            this.fetchProduct()
          } )
            .catch(err =>  console.log(err))
        }
      }
    },
    created () {
      this.getById()
    }
  }
</script>

<style lang="scss" scoped>
  .product-detail__content {
    background-color: white;
    padding: 15px;
    margin-top: 10px;
    .title {
      margin: 0 0 10px;
      color: gray;
      font-weight: bolder;
      text-transform: uppercase;
    }
    .price {
      color: darkred;
      font-size: 30px;
      font-weight: bolder;
      margin-bottom: 10px;
    }
    .submit {
      .input {
        margin-right: 20px;
        input {
          text-align: center !important;
        }
      }
    }
    .category {
      margin-right: 10px;
      border-right: 1px solid #eee;
      padding-right: 10px;
      strong {
        width: 100px;
      }
      .category__name {
        margin-left: 5px;
      }
    }
    .description {
      text-align: justify;
      line-height: 1.1em;
    }
    .content {
      .content__title {
        font-weight: bolder;
        border-left: 3px solid red;
        padding-left: 10px;
      }
      p {
        text-align: justify;
        line-height: 25px;
      }
    }
  }
  .rating {
    .score {
      cursor: pointer;
      &:hover {
        color: darkgoldenrod;
      }
    }
  }
</style>
<template lang="pug">
  div.product-detail__container
    div.container
      bread-crumb
      div.product-detail__content
        el-row(:gutter="20")
          el-col(:xs="24" :sm="8" :md="8" :lg="8" :xl="8")
            div(v-if="product && product.preview_images && product.preview_images.length > 0")
              preview-image(:images="product.preview_images")
            div(v-else)
              preview-image
          el-col(:xs="24" :sm="16" :md="16" :lg="16" :xl="16")
            el-row.product-detail__title(type="flex")
              el-col(:span="24").left
                h4.title {{product.title}}
                span.category
                  strong Danh mục:
                  span.category__name {{product.category}}
                span.rating
                  span.score(v-for="item in 5" @click="rate(item)" :key="item" :style="{color: item <= rating ? 'orange' : ''}")
                    svg-icon(icon-class="fa-solid star")
            el-row
              el-col(:span="24")
              p.description {{product.description}}
              p
                strong Đinh lượng: 
                template {{product.unit}}
              div(v-if="parseFloat(product.discount) > 0")
                div.price {{formatNumber(product.discount)}} (VNĐ)
                div(style="font-size=16px; color: #d6d6d6;margin: 5px 0; text-decoration: line-through;") {{ formatNumber(product.price)}} (VNĐ)
                  span(style="margin-left: 10px;") {{ ((1 - parseFloat((parseFloat(product.discount) / parseFloat(product.price)))) * 100).toFixed(2)}} %
              div(v-else)
                div.price {{formatNumber(product.price)}} (VNĐ)
                  span(style="font-size: .9em;") / {{`${product.quantitative} ${product.unit}`}}
              div.submit
                span
                  el-button(type="success" @click="addToCart(product)" :disabled="product.added || !(enableCartF())")
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
          products(:products="products")
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import PreviewImage from './components/PreviewImage'
  import Products from './components/products/Category'
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
        data: 'byId',
        listProducts: 'list'
      }),
      product () {
        const item = this.data(this.$route.params.id)
        return item ? {
          id: item.id,
          title: item.name,
          img: item.url ,
          category: item.category ? item.category.name : 'Chưa xác định',
          preview_images: item.previews.length > 0 ? item.previews.map(p => ({id: p.id, img: p.url})): [],
          price: item.price,
          discount: item.discount_price,
          inventory: 10,
          unit: item.unit,
          quantitative: item.quantitative,
          added: item.customer_carts && item.customer_carts.length > 0,
          favorite: item.customer_favorites && item.customer_favorites.length > 0,
          description: item.description
        }: {}
      },
      products () {
        return this.listProducts
          .filter(item => (item.category.name === this.product.category && item.id !== this.product.id))
          .map(item => ({
            id: item.id,
            title: item.name,
            img: item.featured && item.featured[0] && item.featured[0].url,
            preview_images: item.previews.length > 0 ? item.previews.map(p => ({id: p.id, img: p.url})): [],
            category: item.category ? item.category.name : 'Chưa xác định',
            price: item.price,
            discount: item.discount_price,
            inventory: 10,
            unit: item.unit,
            quantitative: item.quantitative,
            added: item.customer_carts && item.customer_carts.length > 0,
            favorite: item.customer_favorites && item.customer_favorites.length > 0,
            description: item.description,
            quantity: (item.customer_carts && item.customer_carts.pivot && item.customer_carts.pivot.quantity) || 0
          })).slice(0, 4)
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
        fetchData : 'fetchSingle',
        fetchProduct: 'fetchList'
      }),
      ...mapActions('cart', {
        add2Cart: 'create',
        updateCart: 'update',
        fetchCart: 'fetchList'
      }),
      enableCartF () {
        const apply = this.$store.getters.settings && this.$store.getters.settings.apply
        if(apply) {
          const start = apply.start
          const end = apply.end

          let now = new Date
          let hour = now.getHours() < 10 ? '0' + now.getHours().toString() : now.getHours().toString()
          let minute = now.getMinutes() < 10 ? '0' + now.getMinutes().toString() : now.getMinutes().toString()
          const time = hour+ ':'+ minute
          if (time > start && time < end) return true;
        }
        return false;
      },
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
            this.$notify(
              {
                title: 'Thông báo',
                message: 'Đã thêm thành công vài giỏ hàng',
                type: 'success'
              })
          } )
            .catch(err =>   this.$notify(
              {
                title: 'Cảnh báo',
                message: 'Không thể thêm sản phẩm vào giỏ hàng',
                type: 'danger'
              }))
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
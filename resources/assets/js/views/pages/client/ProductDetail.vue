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
                  strong Mã sản phẩm:
                  span.category__name {{ product.product_code }}
                span.category
                  strong Danh mục:
                  span.category__name {{ getCategoryName(product.category_id) }}
            el-row(style="margin-top: 20px")
              el-col(:span="24")
              div(v-if="parseFloat(product.discount) > 0")
                div.price {{formatNumber(product.discount)}} (VNĐ)
                div(style="font-size=16px; color: #d6d6d6;margin: 5px 0; text-decoration: line-through;") {{ formatNumber(product.price)}} (VNĐ)
                  span(style="margin-left: 10px;") {{ ((1 - parseFloat((parseFloat(product.discount) / parseFloat(product.price)))) * 100).toFixed(2)}} %
              div(v-else)
                div.price {{formatNumber(product.price) || '-' }} (VNĐ)
                  span(style="font-size: .9em;")  / {{ `${product.quantitative || '-'} ${product.unit || '-'}`}}
              div.submit
                span
                  el-button(type="success" @click="addToCart(product)" size="small" :disabled="!canAddToCart(product)")
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
      div.product-detail__relative(v-if="products.length > 0")
        h4 SẢN PHẨM LIÊN QUAN
        div
          products(:products="products")
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import BreadCrumb from './components/BreadCrumb'
  import PreviewImage from './components/PreviewImage'
  import Products from './components/products/Category'
  import Comment from './components/Comment'
  import { formatNumber } from '~/utils/util'
  import moment from 'moment'
  import dummyImage from '~/assets/login_images/dummy-image.jpg'

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
        productById: 'byId',
        listProducts: 'list'
      }),
      ...mapGetters('categories', {
        categories: 'list'
      }),
      ...mapGetters('cart', {
        carts: 'list'
      }),
      product () {
        const item = this.productById(this.$route.params.id)
        if (item === undefined || item === null) return {};
        return {
          id: item.id,
          product_code: item.product_code,
          title: item.name,
          img: (item.featured && item.featured.url) || dummyImage,
          category_id: item.category_id,
          preview_images: item.preview_images && item.preview_images.length > 0 ? item.preview_images.map(p => ({id: p.id, img: p.url})): [],
          price: item.price,
          discount: item.discount_price,
          inventory: 10,
          unit: item.unit,
          quantitative: item.quantitative,
          favorite: item.customer_favorites && item.customer_favorites.length > 0,
          description: item.description
        }
      },
      products () {
        return this.listProducts.filter((item) => {
          return item.category_id &&
            parseInt(item.category_id) === parseInt(this.product.category_id) &&
            parseInt(item.id) !== parseInt(this.product.id);
        }).map(item => ({
          id: item.id,
          title: item.name,
          img: item.featured && item.featured[0] ? item.featured[0].url : dummyImage,
          preview_images: item.previews.length > 0 ? item.previews.map(p => ({id: p.id, img: p.url})): [],
          category: this.getCategoryName(item.category_id),
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
      canAddToCart (product) {
        return !this.isInCart(product) && this.isInOrderTime();
      },
      isInOrderTime () {
        const apply = this.$store.getters.settings && this.$store.getters.settings.apply
        if (apply) {
          const now = moment();
          const startTime = moment(apply.start, 'hh:mm');
          const endTime = moment(apply.end, 'hh:mm');

          if (apply.is_end_in_today) return startTime.isBefore(now) && now.isBefore(endTime)
          return !(endTime.isBefore(now) && now.isBefore(startTime))
        }
        return false;
      },
      isInCart(product) {
        if (!(this.carts && this.carts.length > 0)) return false;
        const target = this.carts.find((item) => {
          return parseInt(item.product_id) === parseInt(product.id);
        });

        return !!target;
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
      },
      getCategoryName(category_id) {
        if (!category_id) return 'Chưa xác định';

        const category = this.categories.find((item) => {
          return item.category_id === category_id;
        });

        return category ? category.name : 'Chưa xác định';
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
</style>
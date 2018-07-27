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
              div.price {{product.discount}}
                span(style="margin-left: 20px; font-size=18px; color: #d6d6d6; text-decoration: line-through;") {{product.price}} VNĐ
              div.submit
                span.input
                  el-input(placeholder="1" style="width: 150px;")
                    template(slot="prepend")
                      el-button(@click="minus") -
                    template(slot="append")
                      el-button +
                span
                  el-button(type="danger") Mua ngay
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
      minus () {
        alert('minus')
      },
      rate (score) {
        this.rating = score
      },
      getById () {
        this.fetchData({
          id: this.$route.params.id
        })
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
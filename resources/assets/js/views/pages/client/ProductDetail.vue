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
                h4.title [HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018
                span.category
                  strong Danh mục:
                  span.category__name SẢN PHẨM MỚI
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
              p.description In marketing, a product is anything that can be offered to a market that might satisfy a want or need. In marketing, a product is anything that can be offered to a market that might satisfy a want or need. In marketing, a product is anything that can be offered to a market that might satisfy a want or need. In retailing, products are called merchandise. In manufacturing, products are bought as raw materials and sold as finished goods. In marketing, a product is anything that can be offered to a market that might satisfy a want or need. In retailing, products are called merchandise. In manufacturing, products are bought as raw materials and sold as finished goods.In marketing, a product is anything that can be offered to a market that might satisfy a want or need. In retailing, products are called merchandise. In manufacturing, products are bought as raw materials and sold as finished goods.
              div.price 45,000 VNĐ
                span(style="margin-left: 20px; font-size=18px; color: #d6d6d6; text-decoration: line-through;") 85,000 VNĐ
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
            p A product can be a service or an item. It can be physical or in virtual or cyber form. Every product is made at a cost and each is sold at a price. The price that can be charged depends on the market, the quality, the marketing and the segment that is targeted. A product can be a service or an item. It can be physical or in virtual or cyber form. Every product is made at a cost and each is sold at a price. The price that can be charged depends on the market, the quality, the marketing and the segment that is targeted. A product can be a service or an item. It can be physical or in virtual or cyber form. Every product is made at a cost and each is sold at a price. The price that can be charged depends on the market, the quality, the marketing and the segment that is targeted. A product can be a service or an item. It can be physical or in virtual or cyber form. Every product is made at a cost and each is sold at a price. The price that can be charged depends on the market, the quality, the marketing and the segment that is targeted. A product can be a service or an item. It can be physical or in virtual or cyber form. Every product is made at a cost and each is sold at a price. The price that can be charged depends on the market, the quality, the marketing and the segment that is targeted. A product can be a service or an item. It can be physical or in virtual or cyber form. Every product is made at a cost and each is sold at a price. The price that can be charged depends on the market, the quality, the marketing and the segment that is targeted.
      div.product-detail__relative
        h4 SẢN PHẨM LIÊN QUAN
        div
          products(:control="false" :items="1")
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import PreviewImage from './components/PreviewImage'
  import Products from './components/products'
  export default {
    name: 'ProductDetail',
    components: {
      BreadCrumb,
      PreviewImage,
      Products
    },
    data () {
      return {
        rating: 5
      }
    },
    methods: {
      minus () {
        alert('minus')
      },
      rate (score) {
        this.rating = score
      }
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
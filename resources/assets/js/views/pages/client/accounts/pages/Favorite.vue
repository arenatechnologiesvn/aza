<template lang="pug">
  div.account-favorite
    h4.account-favorite__title
      svg-icon(icon-class="fa-solid heart")
      template SẢN PHẨM YÊU THÍCH
    div.h-line
    div.account-favorite__content
      el-table(:data="tableData" style="width: 100%" border :show-header="false")
        el-table-column
          template(slot-scope="scope")
            el-row.item(:gutter="10")
              el-col(:span="6")
                img(:src="scope.row.img")
              el-col(:span="18")
                h4 {{scope.row.title}}
                div
                  span(v-for="item in 5" :key="item")
                    svg-icon(icon-class="fa-solid star")
                div
                  span
                    svg-icon(icon-class="fa-solid trash")
        el-table-column(width="200")
          template(slot-scope="scope")
            div(style="text-align: left;")
              div.price {{scope.row.discount}} VNĐ
              div.discount {{scope.row.price}} VNĐ
              div {{((scope.row.discount / scope.row.price) * 100).toFixed(2) }}%
        el-table-column(prop="address" label="Date" width="100")
          template(slot-scope="scope")
            el-button(size="mini" type="warning")
              svg-icon(icon-class="fa-solid cart-plus")
</template>

<script>
  import avatar from '~/assets/products/linh-nguyen.jpg'
  export default {
    name: 'AccountAlert',
    data () {
      return {
        tableData: [
          {
            img: avatar,
            title: 'Bikini Hàn Quốc, độn ngực, thun co giản, sôi động mùa hè, độn ngực, thun co giản, sôi động mùa hè',
            price: 470000,
            discount: 32000,
            rating: 3
          },
          {
            img: avatar,
            title: 'Bikini Hàn Quốc, độn ngực, thun co giản, sôi động mùa hè, độn ngực, thun co giản, sôi động mùa hè',
            price: 470000,
            discount: 32000,
            rating: 3
          },
          {
            img: avatar,
            title: 'Bikini Hàn Quốc, độn ngực, thun co giản, sôi động mùa hè, độn ngực, thun co giản, sôi động mùa hè',
            price: 470000,
            discount: 32000,
            rating: 3
          },
          {
            img: avatar,
            title: 'Bikini Hàn Quốc, độn ngực, thun co giản, sôi động mùa hè, độn ngực, thun co giản, sôi động mùa hè',
            price: 470000,
            discount: 32000,
            rating: 3
          },
          {
            img: avatar,
            title: 'Bikini Hàn Quốc, độn ngực, thun co giản, sôi động mùa hè, độn ngực, thun co giản, sôi động mùa hè',
            price: 470000,
            discount: 32000,
            rating: 3
          }
        ]
      }
    }
  }
</script>

<style lang="scss" scoped>
  .account-favorite {
    background-color: white;
    .price {
      color: darkred;
      font-size: 25px;
    }
    .discount {
      color: #d6d6d6;
      text-decoration: line-through;
      font-size: 18px;
    }
    .item {
      text-align: left;
      img {
        width: 100%;
        height: 130px;
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
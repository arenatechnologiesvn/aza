<template lang="pug">
  div.account-favorite
    h4.account-favorite__title
      svg-icon(icon-class="fa-solid heart")
      template SẢN PHẨM YÊU THÍCH
    div.h-line
    div.account-favorite__content
      el-table(:data="favorites" style="width: 100%" border :show-header="false")
        el-table-column
          template(slot-scope="scope")
            el-row.item(:gutter="10")
              el-col(:span="6")
                img(:src="scope.row.img")
              el-col(:span="18")
                h4 {{scope.row.title}}
                div
                  span(v-for="item in 5" :key="item" :style="{color: item <= scope.row.rating ? 'red': 'black'}")
                    svg-icon(icon-class="fa-solid star")
                div
                  span(@click="removeFromFavorite(scope.row.id)" style="cursor: pointer;")
                    svg-icon(icon-class="fa-solid trash")
        el-table-column(width="250")
          template(slot-scope="scope")
            div(style="text-align: left;")
              div.price {{formatNumber(scope.row.price)}} (VNĐ)
              div.discount {{formatNumber(scope.row.discount)}} (VNĐ)
        el-table-column(prop="address" label="Date" width="100")
          template(slot-scope="scope")
            el-button(size="mini" type="warning" @click="addToCart(scope.row)")
              svg-icon(icon-class="fa-solid cart-plus")
</template>

<script>
  import avatar from '~/assets/products/linh-nguyen.jpg'
  import { mapGetters, mapActions } from 'vuex'
  import { formatNumber } from '~/utils/util'

  export default {
    name: 'AccountAlert',
    computed: {
      ...mapGetters('favorite', {
        favorites: 'favoriteProducts'
      })
    },
    watch: {
      $route: 'fetchData'
    },
    methods: {
      ...mapActions('favorite', {
        fetchFavorite: 'fetchList'
      }),
      addToCart (item) {
        this.$store.dispatch('cart/addProductToCart', item)
      },
      removeFromFavorite (id) {
        this.$store.dispatch('favorite/removeFromFavorite', id)
      },
      fetchData () {
        this.fetchFavorite();
      },
      formatNumber (num) {
        return formatNumber(num)
      }
    },
    created () {
      this.fetchData()
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
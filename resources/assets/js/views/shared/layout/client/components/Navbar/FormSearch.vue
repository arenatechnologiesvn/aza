<template lang="pug">
  div.form-search(style="float: right")
    span.form-group
      el-input(placeholder="Tìm kiếm danh mục, sản phẩm" prefix-icon="el-icon-search")
    span.shopcart(style="color: black;")
      el-dropdown.top__dropdown(v-if="total > 0")
        el-badge(:value="total" class="item")
          router-link(to="/home/cart")
            svg-icon(icon-class="fa-solid shopping-cart")
        el-dropdown-menu(slot="dropdown")
          div
            table.cart-dropdown
              tbody
                tr(v-for="item in items" :key="item.id")
                  td(style="width: 20%")
                    img(:src="item.img" width="50" height="50")
                  td(style="width: 60%")
                    p(style="line-height: 20px;") {{item.title}}
                  td(style="width: 10%")
                    el-tag(type="danger" size="mini") {{item.quantity}}
                  td(style="width: 10%")
                    span.remove-item__cart(@click="RemoveFromCart(item)")
                      svg-icon(icon-class="fa-solid times")
              tfoot
                tr(style="border-top: 1px solid red;")
                  td(colspan="4")
                    router-link(to="/home/cart" class="el-button el-button--success") Thanh Toán
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  export default {
    name: 'FormSearch',
    computed: {
      ...mapGetters('cart', {
        total: 'total',
        items: 'cartProducts'
      })
    },
    methods: {
      ...mapActions('cart', {
        remove: 'removeFromCard'
      }),
      RemoveFromCart (item) {
        this.remove(item)
      }
    }
  }
</script>

<style lang="scss" scoped>
  .cart-dropdown {
    width: 100%;
    max-width: 300px;
    max-height: 400px;
    overflow-y: scroll;
    tr {
      border-bottom: 1px solid #d6d6d6;
      vert-align: middle;
      padding: 5px;
    }
    .remove-item__cart {
      cursor: pointer;
    }
  }
</style>
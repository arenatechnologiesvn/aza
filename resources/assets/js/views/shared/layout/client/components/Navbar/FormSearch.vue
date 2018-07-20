<template lang="pug">
  div.form-search(style="float: right")
    span.form-group
      el-input(placeholder="Tìm kiếm danh mục, sản phẩm" prefix-icon="el-icon-search")
    span.shopcart(style="color: black;")
      el-dropdown.top__dropdown
        el-badge(:value="total" class="item")
          router-link(to="/home/cart")
            svg-icon(icon-class="fa-solid shopping-cart")
        el-dropdown-menu(slot="dropdown")
          el-dropdown-item.cart-item(v-for="item in items" :key="item.id")
            el-row(:gutter="20" type="flex" style="width: 300px;")
              el-col(:span="6")
                img(:src="item.img" width="50" height="50")
              el-col(:span="12")
                p(style="line-height: 20px") {{item.title}}
              el-col(:span="4")
                span {{item.quantity}}
              el-col(:span="2")
                span
                  svg-icon(icon-class="fa-solid times")

</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    name: 'FormSearch',
    computed: {
      ...mapGetters('cart', {
        total: 'total',
        items: 'cartProducts'
      })
    }
  }
</script>

<style scoped>
  .cart-item:not(:last-child) {
    border-bottom: 2px solid #eeee;
    vert-align: middle;
    padding: 10px 5px;
  }
</style>
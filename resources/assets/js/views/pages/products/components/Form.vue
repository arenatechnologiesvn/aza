<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid piggy-bank")
        span(style="margin-left: 10px;") Thêm mới sản phẩm
      el-dropdown(style="float: right; padding-right: 7px; cursor: pointer;")
        span.el-dropdown-link
          svg-icon(icon-class="fa-solid cog")
          i(class="el-icon-arrow-down el-icon--right")
        el-dropdown-menu(slot="dropdown")
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid shopping-basket")
              span(style="margin-left: 5px;") Thêm mới danh mục
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid hand-pointer")
              span(style="margin-left: 5px;") Thêm mới nhà cung cấp
    el-row
      el-col(:span="4")
        img(:src="product_image" style="width: 100%" height="230")
        div(style="text-align: center; margin-top: 10px;")
          el-button(type="success") Thay đổi
      el-col(:span="20")
        el-form(ref="form" v-model="form")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.name" placeholder="Tên sản phẩm")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.code" placeholder="Mã sản phẩm")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.price" placeholder="Giá sản phẩm")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.discount_price" placeholder="Giá khuyến mải")
          el-col(:span="12")
            el-form-item
              el-select(v-model="form.category_id" clearable placeholder="Danh mục sản phẩm" style="width: 100%")
                el-option(value="1")
                  svg-icon(icon-class="fa-solid lock")
                  span(style="margin-left: 5px;") Thực phẩm
                el-option(label="Hải sản" value="2")
          el-col(:span="12")
            el-form-item
              el-select(v-model="form.company_id" clearable placeholder="Nhà cung cấp" style="width: 100%")
                el-option(label="Pepsi" value="1")
                el-option(label="Coca Cola" value="2")
          el-col(:span="24")
            el-form-item
              el-input(type="textarea" rows="10" v-model="form.description" placeholder="Mô tả sản phẩm")
          el-col(:span="24")
            el-form-item(style="text-align: right;")
              el-button(type="primary")
                svg-icon(icon-class="fa-solid save")
                span(style="margin-left: 10px") Lưu
              el-button(type="danger")
                svg-icon(icon-class="fa-solid ban")
                span(style="margin-left: 10px") Hủy bỏ
</template>
<script>
  import product_image from '~/assets/login_images/linh-nguyen.jpg'

  export default {
    name: 'ProductForm',
    computed: {
    },
    data () {
      return {
        product_image,
        form: {
          name: '',
          code: '',
          price:'',
          discount_price: '',
          category_id: '',
          company_id:'',
          description: ''
        }
      }
    }
  }
</script>

<style>
  .el-form-item {
    margin: 10px;
  }
</style>
<template lang="pug">
  div.form__container
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
      product-form
      el-row(type="flex" justify="end" style="text-align: right; margin: 10px 14px 0 0;")
        el-col(:span="24")
          el-button(type="primary" size="small" @click="saveProduct")
            svg-icon(icon-class="fa-solid save")
            span(style="margin-left: 10px") Lưu
          el-button(type="info" size="small" @click="backToListPage")
            svg-icon(icon-class="fa-solid ban")
            span(style="margin-left: 10px") Hủy bỏ
    media-manager-modal(type="product")
</template>

<script>
  import ProductForm from './components/Form';
  import MediaManagerModal from '~/components/MediaManager/modal';

  export default {
    name: 'CreateProduct',
    components: {
      ProductForm,
      MediaManagerModal
    },
    methods: {
      saveProduct() {
        storeProduct(this.form).then(() => {
          this.$router.push({path: '/products'});
        }).catch(error => {
          console.log(error);
        });
      },
      backToListPage() {
        this.$router.push({path: '/products'});
      }
    }
  }
</script>

<style scoped>

</style>
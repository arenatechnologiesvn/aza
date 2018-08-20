<template lang="pug">
  div.form__container
    el-card
      div.clearfix(slot="header")
        span
          svg-icon(icon-class="fa-solid plus-circle")
          span(style="margin-left: 10px;") Thêm mới sản phẩm
      product-form(ref="productCreateForm")
      el-row(type="flex" justify="end" style="text-align: right; margin: 10px 14px 0 0;")
        el-col(:span="24")
          el-button(type="primary" size="small" @click="save")
            svg-icon(icon-class="fa-solid save")
            span(style="margin-left: 10px") Lưu
          el-button(type="info" size="small" @click="cancel")
            svg-icon(icon-class="fa-solid ban")
            span(style="margin-left: 10px") Hủy bỏ
    media-manager-modal(type="product")
</template>

<script>
  import ProductForm from './components/Form';
  import MediaManagerModal from '~/components/MediaManager/modal';
  import { mapActions, mapGetters } from 'vuex';

  export default {
    name: 'CreateProduct',
    components: {
      ProductForm,
      MediaManagerModal
    },
    methods: {
      save() {
        this.$confirm('Bạn có muốn tạo sản phẩm này không?', 'Xác nhận', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          this.$refs.productCreateForm.create();
        }).catch(() => {
          // Do nothing
        });
      },

      cancel() {
        this.$confirm('Bạn có muốn hủy tạo sản phẩm này không?', 'Xác nhận', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Hủy',
          type: 'warning'
        }).then(() => {
          this.$router.push({ path: '/products' });
        }).catch(() => {
          // Do nothing
        });
      }
    }
  }
</script>
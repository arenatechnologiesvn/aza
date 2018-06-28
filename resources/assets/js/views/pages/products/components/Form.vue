<template lang="pug">
  el-row
    el-col.side-form(:span="6")
      .image-container
        img.image-preview(:src="form.preview_images" width="100%")
      div(style="margin-top: 10px;")
        el-button(type="success" size="small" @click="$refs.mediaProductModal.dialogVisible = true") Thay đổi
      media-manager-modal(type="product" v-model="form.preview_images" ref="mediaProductModal")
    el-col(:span="18")
      el-form(ref="form" v-model="form" size="small")
        el-col(:span="12")
          el-form-item
            el-input(v-model="form.name" placeholder="Tên sản phẩm")
        el-col(:span="12")
          el-form-item
            el-input(v-model="form.product_code" placeholder="Mã sản phẩm")
        el-col(:span="12")
          el-form-item
            el-input(v-model="form.price" placeholder="Giá sản phẩm (VND)")
        el-col(:span="12")
          el-form-item
            el-input(v-model="form.discountPrice" placeholder="Giá khuyến mãi (VND)")
        el-col(:span="12")
          el-form-item
            el-select(v-model="form.categoryId" clearable placeholder="Danh mục sản phẩm" style="width: 100%")
              el-option(v-for="item in categories" :key="item.id" :label="item.name" :value="item.id")
                svg-icon(:icon-class="item.icon")
                span(style="margin-left: 5px") {{ item.name }}
        el-col(:span="12")
          el-form-item
            el-select(v-model="form.providerId" clearable placeholder="Nhà cung cấp" style="width: 100%")
              el-option(v-for="item in providers" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="12")
          el-form-item
            el-select(v-model="form.unit" clearable placeholder="Đơn vị" style="width: 100%")
              el-option(v-for="(item, index) in productUnits" :key="index" :label="item" :value="item")
        el-col(:span="24")
          el-form-item
            el-input(type="textarea" rows="10" v-model="form.description" placeholder="Mô tả sản phẩm")
</template>
<script>
import MediaManagerModal from '~/components/MediaManager/modal';
import dummyImage from '~/assets/login_images/dummy-image.jpg';
import { mapGetters, mapActions, mapState } from 'vuex';

const PRODUCT_UNITS = ['Kg', 'Hộp', 'Thùng', 'Chai', 'Lon'];

export default {
  name: 'ProductForm',
  components: {
    MediaManagerModal
  },
  model: {
    prop: 'form',
    event: 'click'
  },
  props: {
    form: Object
  },
  data () {
    return {
      categories: [],
      providers: [],
      productUnits: PRODUCT_UNITS,
    }
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

<style lang="scss" scoped>
  .el-form-item {
    margin: 10px;
  }

  .side-form {
    text-align: center;

    .image-container {
      position: relative;
      width: 100%;
      padding-top: 100%;
      margin-top: 10px;

      .image-preview {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border: 1px solid #dcdfe6;
      }
    }
  }
</style>
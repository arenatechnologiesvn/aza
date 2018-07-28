<template lang="pug">
  el-row
    el-col.side-form(:span="6")
      .image-container
        img.image-featured(:src="featuredImageUrl()" width="100%")
      div(style="margin-top: 10px;")
        el-button(type="success" size="small" @click="openMediaModal('single')") Thay đổi ảnh đại diện
    el-col(:span="18")
      el-form(ref="form" :rules="rules" :model="product" size="small")
        el-col(:span="24")
          el-form-item(prop="name" label="Tên sản phẩm:")
            el-input(v-model="product.name" placeholder="Tên sản phẩm")
        el-col(:span="12")
          el-form-item(prop="product_code" label="Mã sản phẩm:")
            el-input(v-model="product.product_code" placeholder="Mã sản phẩm")
        el-col(:span="6")
          el-form-item(prop="unit" label="Đơn vị:")
            el-select(v-model="product.unit" clearable placeholder="Đơn vị" style="width: 100%")
              el-option(v-for="(item, index) in productUnits" :key="index" :label="item" :value="item")
        el-col(:span="6")
          el-form-item(prop="quantitative" label="Định lượng:")
            el-input(v-model="product.quantitative" placeholder="Ví dụ: 0.2, 0.5,..")
        el-col(:span="12")
          el-form-item(prop="price" label="Giá sản phẩm:")
            el-input(v-model.number="product.price" placeholder="Ví dụ: 24000")
              template(slot="append") VNĐ
        el-col(:span="12")
          el-form-item(prop="discount_price" label="Giá khuyến mãi:")
            el-input(v-model.number="product.discount_price" placeholder="Ví dụ: 23500")
              template(slot="append") VNĐ
        el-col(:span="12")
          el-form-item(prop="category_id" label="Danh mục sản phẩm:")
            el-select(v-model="product.category_id" clearable placeholder="Danh mục sản phẩm" style="width: 100%")
              el-option(v-for="item in categories" :key="item.id" :label="item.name" :value="item.id")
                svg-icon(:icon-class="item.icon")
                span(style="margin-left: 5px") {{ item.name }}
        el-col(:span="12")
          el-form-item(prop="provider_id" label="Nhà cung cấp:")
            el-select(v-model="product.provider_id" clearable placeholder="Nhà cung cấp" style="width: 100%")
              el-option(v-for="item in providers" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="24")
          el-form-item(prop="description" label="Mô tả:")
            el-input(type="textarea" rows="10" v-model="product.description" placeholder="Mô tả sản phẩm")
        el-col(:span="24")
          el-form-item(prop="preview_images")
            el-card
              div.clearfix(slot="header")
                span
                  svg-icon(icon-class="fa-solid image")
                  span(style="margin-left: 5px") Ảnh chi tiết sản phẩm
                div(style="float: right")
                  el-button(type="text" @click="openMediaModal('multi')") Thay đổi
                  span  /
                  el-button(type="text" style="color: red" @click="clearAllPreviewImages()")  Xóa tất cả

              ul.preview-container
                li.preview-item(v-for="(image, index) in product.preview_images" :key="index")
                  img.preview-image(:src="image.url" width="100%")

</template>
<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import dummyImage from '~/assets/login_images/dummy-image.jpg';

const PRODUCT_UNITS = ['Kg', 'Hộp', 'Thùng', 'Chai', 'Lon', 'Bịch'];

export default {
  name: 'ProductForm',
  computed: {
    ...mapGetters({
      productById: 'products/byId',
      getFormProduct: 'products/getFormProduct',
      selectedSingleImage: 'media/selectedSingleMedia',
      selectedMultiImage: 'media/selectedMultiMedia',
      categories: 'categories/list',
      providers: 'providers/list'
    }),

    ...mapState({
      productId: state => state.common.product.editId,
      panelOpen: state => state.common.product.editPanelVisible
    }),

    currentProduct() {
      return this.productById(this.productId);
    }
  },
  data () {
    const validatePrice = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('Giá sản phẩm không được trống'));
      } else if (!Number.isInteger(value)) {
        callback(new Error('Giá sản phẩm không đúng'));
      } else if (this.product.discount_price && value <= this.product.discount_price) {
        callback(new Error('Giá sản phẩm phải lớn hơn giá khuyến mãi'));
      } else {
        callback();
      }
    };

    const validateDiscountPrice = (rule, value, callback) => {
      if (value) {
        if (!Number.isInteger(value)) {
          callback(new Error('Giá sản phẩm không đúng'));
        } else if (value >= this.product.price) {
          callback(new Error('Giá khuyễn mãi phải nhỏ hơn giá sản phẩm'));
        } else {
          callback();
        }
      } else {
        callback();
      }
    };

    return {
      productUnits: PRODUCT_UNITS,
      product: {},
      rules: {
        name: [
          { required: true, message: 'Tên sản phẩm không được trống', trigger: 'blur' },
          { max: 255, message: 'Tên sản phẩm phải nhỏ hơn 255 ký tự', trigger: 'blur' }
        ],
        product_code: [
          { required: true, message: 'Mã sản phẩm không được trống', trigger: 'blur' },
          { max: 255, message: 'Mã sản phẩm phải nhỏ hơn 255 ký tự', trigger: 'blur' }
        ],
        unit: [
          { required: true, message: 'Đơn vị không được trống', trigger: 'change' }
        ],
        quantitative: [
          { required: true, message: 'Định lượng không được trống', trigger: 'blur' }
        ],
        price: [
          { validator: validatePrice, trigger: 'blur' }
        ],
        discount_price: [
          { validator: validateDiscountPrice, trigger: 'blur' }
        ],
        description: [
          { max: 500, message: 'Mô tả phải nhỏ hơn 255 ký tự', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    fetchPrepareData() {
      this.product = JSON.parse(JSON.stringify(this.getFormProduct));
      this.fetchCategories();
      this.fetchProviders();
    },

    create() {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.createProduct({ data: this.prepareParams() }).then(() => {
            this.$router.push({ path: '/products' });
          });
        }
      });
    },

    update() {
      this.$refs.form.validate((valid) => {
        if (valid && this.productId) {
          this.updateProduct({ id: this.productId, data: this.prepareParams() }).then(() => {
            this.fetchProducts().then(() => {
              this.closeProductEditPanel();
            });
          });
        }
      });
    },

    prepareParams() {
      const params = JSON.parse(JSON.stringify(this.product));

      if (this.product.featured_image) {
        params.featured_image = this.product.featured_image.id;
      } else {
        delete params.featured_image;
      }

      params.preview_images = this.product.preview_images.map(image => {
        return image.id;
      });

      return params;
    },

    resetForm(formName) {
      this.$refs.form.resetFields();
    },

    featuredImageUrl() {
      return this.product.featured_image ? this.product.featured_image.url : dummyImage;
    },

    clearAllPreviewImages() {
      this.product.preview_images = [];
    },

    ...mapActions({
      openMediaModal: 'common/openMediaManagerModal',
      fetchCategories: 'categories/fetchList',
      fetchProviders: 'providers/fetchList',
      fetchProducts: 'products/fetchList',
      createProduct: 'products/create',
      updateProduct: 'products/update',
      closeProductEditPanel: 'common/closeProductEditPanel'
    })
  },
  watch: {
    panelOpen() {
      if (this.panelOpen && this.productId) {
        this.resetForm();
        this.product = JSON.parse(JSON.stringify(this.currentProduct));
      }
    },

    selectedSingleImage() {
      if (this.selectedSingleImage) {
        this.product.featured_image = this.selectedSingleImage;
      }
    },

    selectedMultiImage() {
      if (this.selectedMultiImage.length) {
        this.product.preview_images = this.selectedMultiImage;
      }
    }
  },
  created() {
    this.fetchPrepareData();
  }
}
</script>

<style lang="scss">
  .el-form-item {
    margin: 10px;

    &__error {
      padding: 2px 5px 0;
    }
  }
</style>

<style lang="scss" scoped>
  .side-form {
    text-align: center;

    .image-container {
      position: relative;
      width: 100%;
      padding-top: 100%;
      margin-top: 10px;

      .image-featured {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border: 1px solid #dcdfe6;
      }
    }
  }

  .preview-container {
    list-style: none;
    padding: 0;
    margin: 0;

    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    flex-flow: row wrap;
    
    -webkit-flex-flow: row wrap;
    align-content: flex-start;

    .preview-item {
      padding: 3px;

      .preview-image {
        width: 80px;
        height: 80px;
      }
    }
  }
</style>
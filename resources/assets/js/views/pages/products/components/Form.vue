<template lang="pug">
  el-row
    el-col.side-form(:span="6")
      .image-container
        img.image-featured(:src="product.featured_image.url" width="100%")
      div(style="margin-top: 10px;")
        el-button(type="success" size="small" @click="openMediaModal") Thay đổi ảnh đại diện
    el-col(:span="18")
      el-form(ref="form" :rules="rules" :model="product" size="small")
        el-col(:span="24")
          el-form-item(prop="name" label="Tên sản phẩm:")
            el-input(v-model="product.name" placeholder="Tên sản phẩm")
        el-col(:span="12")
          el-form-item(prop="product_code" label="Mã sản phẩm:")
            el-input(v-model="product.product_code" placeholder="Mã sản phẩm")
        el-col(:span="12")
          el-form-item(prop="unit" label="Đơn vị:")
            el-select(v-model="product.unit" clearable placeholder="Đơn vị" style="width: 100%")
              el-option(v-for="(item, index) in productUnits" :key="index" :label="item" :value="item")
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
</template>
<script>
import { mapGetters, mapActions, mapState } from 'vuex';

const PRODUCT_UNITS = ['Kg', 'Hộp', 'Thùng', 'Chai', 'Lon'];

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
          this.createProduct({ data: this.product }).then(() => {
            this.$router.push({ path: '/products' });
          });
        }
      });
    },

    update() {
      this.$refs.form.validate((valid) => {
        if (valid && this.productId) {
          this.updateProduct({ id: this.productId, data: this.product }).then(() => {
            this.fetchProducts().then(() => {
              this.closeProductEditPanel();
            });
          });
        }
      });
    },

    resetForm(formName) {
      this.$refs.form.resetFields();
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
</style>
<template lang="pug">
  el-row
    el-col.side-form(:span="6")
      .image-container
        img.image-preview(:src="product.preview_images" width="100%")
      div(style="margin-top: 10px;")
        el-button(type="success" size="small" @click="openMediaModal") Thay đổi
    el-col(:span="18")
      el-form(ref="form" :rules="rules" :model="product" size="small")
        el-col(:span="12")
          el-form-item(prop="name")
            el-input(v-model="product.name" placeholder="Tên sản phẩm")
        el-col(:span="12")
          el-form-item(prop="product_code")
            el-input(v-model="product.product_code" placeholder="Mã sản phẩm")
        el-col(:span="12")
          el-form-item(prop="price" )
            el-input(v-model="product.price" placeholder="Giá sản phẩm")
              template(slot="append") VND
        el-col(:span="12")
          el-form-item(prop="discount_price")
            el-input(v-model="product.discount_price" placeholder="Giá khuyến mãi")
              template(slot="append") VND
        el-col(:span="12")
          el-form-item(prop="category_id")
            el-select(v-model="product.category_id" clearable placeholder="Danh mục sản phẩm" style="width: 100%")
              el-option(v-for="item in categories" :key="item.id" :label="item.name" :value="item.id")
                svg-icon(:icon-class="item.icon")
                span(style="margin-left: 5px") {{ item.name }}
        el-col(:span="12")
          el-form-item(prop="provider_id")
            el-select(v-model="product.provider_id" clearable placeholder="Nhà cung cấp" style="width: 100%")
              el-option(v-for="item in providers" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="12")
          el-form-item(prop="unit")
            el-select(v-model="product.unit" clearable placeholder="Đơn vị" style="width: 100%")
              el-option(v-for="(item, index) in productUnits" :key="index" :label="item" :value="item")
        el-col(:span="24")
          el-form-item(prop="description")
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
      selectedImageUrl: 'media/selectedMediaUrl',
      categories: 'categories/list',
      providers: 'providers/list'
    }),

    ...mapState({
      productId: state => state.common.product.editId
    }),

    currentProduct() {
      return this.productById(this.productId);
    }
  },
  data () {
    return {
      productUnits: PRODUCT_UNITS,
      product: {},
      rules: {
        name: [
          { required: true, message: 'Làm ơn nhập tên sản phẩm', trigger: 'blur' },
          { max: 255, message: 'Tên sản phẩm phải nhỏ hơn 255 ký tự', trigger: 'blur' }
        ],
        product_code: [
          { required: true, message: 'Làm ơn nhập mã sản phẩm', trigger: 'blur' },
          { max: 255, message: 'Mã sản phẩm phải nhỏ hơn 255 ký tự', trigger: 'blur' }
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

    isValidForm() {
      return new Promise((resolve) => {
        this.$refs.form.validate((valid) => {
          resolve(valid);
        });
      });
    },

    ...mapActions({
      openMediaModal: 'common/openMediaManagerModal',
      fetchCategories: 'categories/fetchList',
      fetchProviders: 'providers/fetchList',
      setFormProduct: 'products/setFormProduct'
    })
  },
  watch: {
    productId() {
      if (this.productId) {
        this.product = JSON.parse(JSON.stringify(this.currentProduct));
        this.setFormProduct(this.product);
      }
    },

    selectedImageUrl() {
      if (this.selectedImageUrl) {
        this.product.preview_images = this.selectedImageUrl;
        this.product.featured_images = this.selectedImageUrl;
      }
    },
  },
  created() {
    this.fetchPrepareData();
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
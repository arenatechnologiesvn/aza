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
        img(:src="form.imageUrl" style="width: 100%" height="230")
        div(style="text-align: center; margin-top: 10px;")
          el-button(type="success" @click="$refs.mediaProductModal.dialogVisible = true") Thay đổi
        media-manager-modal(type="product" v-model="form.imageUrl" ref="mediaProductModal")
      el-col(:span="20")
        el-form(ref="form" v-model="form")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.name" placeholder="Tên sản phẩm")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.product_code" placeholder="Mã sản phẩm")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.price" placeholder="Giá sản phẩm")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.discountPrice" placeholder="Giá khuyến mãi")
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
          el-col(:span="24")
            el-form-item(style="text-align: right;")
              el-button(type="primary" @click="saveProduct")
                svg-icon(icon-class="fa-solid save")
                span(style="margin-left: 10px") Lưu
              el-button(type="danger" @click="backToListPage")
                svg-icon(icon-class="fa-solid ban")
                span(style="margin-left: 10px") Hủy bỏ
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
  created() {
    getCategories().then(response => {
      this.categories = response.data;
    }).catch(error => {
      this.categories = [];
    });

    getProviders().then(response => {
      this.providers = response.data;
    }).catch(error => {
      this.providers = [];
    });
  },
  data () {
    return {
      categories: [],
      providers: [],
      productUnits: PRODUCT_UNITS,
      form: {
        name: '',
        product_code: '',
        price:'',
        unit: '',
        imageUrl: dummyImage,
        discountPrice: '',
        categoryId: '',
        providerId:'',
        description: ''
      }
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

<style>
  .el-form-item {
    margin: 10px;
  }
</style>
<template lang="pug">
  el-row
    el-col(:span="5" style="padding-right: 10px;")
      img(:src="selectedImageUrl()" style="width: 100%" height="230")
      div(style="text-align: center; margin-top: 10px;")
        el-button(type="success" @click="openMediaModal('single')" size="small") Thay đổi
    el-col(:span="19")
      el-form(ref="form" v-model="shop")
        el-col(:span="12")
          el-form-item
            el-input(v-model="shop.name" placeholder="Tên cửa hàng")
        el-col(:span="12")
          el-form-item
            el-select(v-model="shop.customer_id" clearable placeholder="Khách hàng" style="width: 100%")
              el-option(v-for="item in customerList" :key="item.id" :label="item.value" :value="item.id")
        el-col(:span="12")
          el-form-item
            el-input(v-model="shop.phone" placeholder="Điện thoại")
        el-col(:span="12")
          el-form-item
            el-input(v-model="shop.home_phone" placeholder="Điện thoại bàn")
        el-col(:span="24")
          el-form-item
            el-input(v-model="shop.address" placeholder="Địa chỉ")
        el-col(:span="24")
          administrative-select(v-model="shop.selectedProvince" :selectedAdministrative="shop.selectedProvince")
        el-col(:span="24")
          el-form-item
            el-input(v-model="shop.description" rows="5" type="textarea")
        el-col(:span="24")
          el-form-item(style="text-align: right;")
            el-button(type="primary" @click="handleSubmit" size="small")
              svg-icon(icon-class="fa-solid save")
              span(style="margin-left: 10px") Lưu
            el-button(type="danger" @click="back" size="small")
              svg-icon(icon-class="fa-solid ban")
              span(style="margin-left: 10px") Hủy bỏ
    media-manager-modal(type="shop")
</template>

<script>
  import AdministrativeSelect from '~/components/AdministrativeSelect'
  import MediaManagerModal from '~/components/MediaManager/modal';
  import dummyImage from '~/assets/login_images/dummy-image.jpg';
  import { mapGetters, mapActions } from 'vuex'

  export default {
    name: 'EmployeeForm',
    components: {
      AdministrativeSelect,
      MediaManagerModal
    },
    props: {
      shop: {
        type: Object,
        default: () => {
          return {
            name: '',
            phone: '',
            featured_image: '',
            home_phone: '',
            selectedProvince: {},
            address: '',
            customer_id: null,
            description: ''
          }
        }
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters('customers', {
        customers: 'list'
      }),
      ...mapGetters('media', {
        selectedImage: 'selectedSingleMedia',
      }),
      customerList () {
        return this.customers.map(item => {
          return {
            id: item.id,
            value: item.full_name
          }
        })
      }
    },
    methods: {
      ...mapActions('customers', {
        fetchCustomers: 'fetchList'
      }),
      ...mapActions('shops', {
        createShop: 'create',
        updateShop: 'update'
      }),
      ...mapActions('common', {
        openMediaModal: 'openMediaManagerModal'
      }),
      back () {
        this.$router.go(-1)
      },
      update () {
        this.updateShop({
          id: this.$route.params.id,
          data: this.shop
        }).then(res => {
          this.$router.push({name: 'shops', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot update shop');
        })
      },
      create () {
        this.createShop({
          data: this.shop
        }).then(res => {
          this.$router.push({name: 'shops'})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create shop');
        })
      },
      handleSubmit () {
        this.isUpdate ? this.update() : this.create()
      },
      selectedImageUrl() {
        return this.shop.featured_image ? this.shop.featured_image.url : dummyImage;
      }
    },
    watch: {
      selectedImage() {
        if (this.selectedImage) {
          this.shop.featured_image = this.selectedImage;
        }
      }
    },
    created () {
      this.fetchCustomers();
    }
  }
</script>

<style scoped>

</style>
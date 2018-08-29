<template lang="pug">
  el-row
    el-col(:span="12")
      el-form(ref="shopForm" :rules="rules" :model="shop" size="small")
        el-col(:span="24")
          el-form-item(prop="name" label="Tên cửa hàng:")
            el-input(v-model="shop.name" placeholder="Tên cửa hàng")
        el-col(:span="12")
          el-form-item(prop="customer_id" label="Khách hàng:")
            el-select(v-model="shop.customer_id" clearable placeholder="Khách hàng" style="width: 100%")
              el-option(v-for="item in customerList" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="12")
          el-form-item(prop="phone" label="Điện thoại:")
            el-input(v-model="shop.phone" placeholder="Ví dụ: 09876085....")
        el-col(:span="24")
          el-form-item(prop="address" label="Địa chỉ:")
            el-input(v-model="shop.address" placeholder="Ví du: 99 Lê Duẩn / Thôn 1 ...")
        el-col(:span="8")
          el-form-item(prop="province_code" label="Tỉnh/TP:")
            province-select(v-model="shop.province_code")
        el-col(:span="8")
          el-form-item(prop="district_code" label="Huyện/Quận:")
            district-select(v-model="shop.district_code" :parent-code="shop.province_code")
        el-col(:span="8")
          el-form-item(prop="ward_code" label="Xã/Phường:")
            ward-select(v-model="shop.ward_code" :parent-code="shop.district_code")
        el-col(:span="24")
          el-form-item(prop="description" label="Mô tả:")
            el-input(type="textarea" rows="5" v-model="shop.description" placeholder="Mô tả cửa hàng")
        el-col(:span="24")
          el-form-item(style="text-align: right;")
            el-button(type="primary" @click="handleSubmit" size="small")
              svg-icon(icon-class="fa-solid save")
              span(style="margin-left: 10px") Lưu
            el-button(type="danger" @click="back" size="small")
              svg-icon(icon-class="fa-solid ban")
              span(style="margin-left: 10px") Hủy bỏ
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import ProvinceSelect from '~/components/AdministrativeSelect/Province'
  import DistrictSelect from '~/components/AdministrativeSelect/District'
  import WardSelect from '~/components/AdministrativeSelect/Ward'

  export default {
    name: 'ShopForm',
    components: {
      ProvinceSelect,
      DistrictSelect,
      WardSelect
    },
    props: {
      shop: {
        type: Object,
        default: () => {
          return {
            name: '',
            customer_id: null,
            phone: '',
            address: '',
            zone: '',
            province_code: '',
            district_code: '',
            ward_code: '',
            description: ''
          }
        }
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        rules: {
          name: [
            { required: true, message: 'Tên cửa hàng không được trống', trigger: 'blur' },
            { max: 100, message: 'Tên cửa hàng phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ],
          customer_id: [
            { required: true, message: 'Khách hàng không được trống', trigger: 'change' }
          ],
          province_code: [
            { required: true, message: 'Tỉnh/TP không được trống', trigger: 'change' }
          ],
          district_code: [
            { required: true, message: 'Huyện/Quận không được trống', trigger: 'change' }
          ],
          ward_code: [
            { required: true, message: 'Xã/Phường không được trống', trigger: 'change' }
          ],
          phone: [
            { required: true, message: 'Điện thoại không được trống', trigger: 'blur' },
            { max: 20, message: 'Điện thoại phải nhỏ hơn 15 ký tự', trigger: 'blur' }
          ],
          address: [
            { required: true, message: 'Địa chỉ không được trống', trigger: 'blur' },
            { max: 255, message: 'Địa chỉ phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ],
          description: [
            { max: 500, message: 'Địa chỉ phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ],
        }
      }
    },
    computed: {
      ...mapGetters('customers', {
        customers: 'list'
      }),
      ...mapGetters('administrative', {
        getZoneByProvince: 'getZoneByProvince',
        getZoneByDistrict: 'getZoneByDistrict',
        getZoneByWard: 'getZoneByWard'
      }),
      customerList () {
        return this.customers.map(item => {
          return {
            id: item.id,
            name: item.user.full_name
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
      back () {
        this.$router.go(-1)
      },
      update (params) {
        this.updateShop({
          id: this.$route.params.id,
          data: params
        }).then(res => {
          this.$router.push({name: 'shop_index', replace: true})
        }).catch(err => {
          this.$message.error('Cập nhật cửa hàng thất bại');
        })
      },
      create (params) {
        this.createShop({
          data: params
        }).then(res => {
          this.$router.push({name: 'shop_index', replace: true})
        }).catch(err => {
          this.$message.error('Tạo mới cửa hàng thất bại');
        })
      },
      handleSubmit () {
        this.$refs.shopForm.validate((valid) => {
          if (valid) {
            const params = JSON.parse(JSON.stringify(this.shop));
            params.zone = this.renderZone();
            this.isUpdate ? this.update(params) : this.create(params);
          }
        });
      },
      renderZone() {
        if (this.shop.ward_code) {
          return this.getZoneByWard(this.shop.ward_code);
        }

        if (this.shop.district_code) {
          return this.getZoneByDistrict(this.shop.district_code);
        }

        if (this.shop.province_code) {
          return this.getZoneByProvince(this.shop.province_code);
        }

        return '';
      },
    },
    created () {
      this.fetchCustomers();
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
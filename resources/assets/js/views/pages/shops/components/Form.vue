<template lang="pug">
  el-row
    el-col(:span="4")
      img(:src="logo_img" style="width: 100%" height="230")
      div(style="text-align: center; margin-top: 10px;")
        el-button(type="success") Thay đổi
    el-col(:span="20")
      el-form(ref="form" v-model="shop")
        el-col(:span="12")
          el-form-item
            el-input(v-model="shop.name" placeholder="Tên cửa hàng")
        el-col(:span="12")
          el-form-item
            el-select(v-model="shop.customer_id" clearable placeholder="Khách hàng" style="width: 100%")
              el-option(v-for="item in customerList" :key="item.id" :label="item.name" :value="item.id")
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
          administrative-select(v-model="shop.selectedProvince")
        el-col(:span="24")
          el-form-item
            el-input(v-model="shop.description" rows="5" type="textarea")
        el-col(:span="24")
          el-form-item(style="text-align: right;")
            el-button(type="primary" @click="handleSubmit")
              svg-icon(icon-class="fa-solid save")
              span(style="margin-left: 10px") Lưu
            el-button(type="danger" @click="back")
              svg-icon(icon-class="fa-solid ban")
              span(style="margin-left: 10px") Hủy bỏ
</template>

<script>
  import logo_img from '~/assets/login_images/linh-nguyen.jpg'
  import AdministrativeSelect from '~/components/AdministrativeSelect'
  import { mapGetters } from 'vuex'

  export default {
    name: 'EmployeeForm',
    components: {
      AdministrativeSelect
    },
    data () {
      return {
        logo_img
      }
    },
    props: {
      shop: {
        type: Object,
        default: () => {
          return {
            name: '',
            phone: '',
            preview_image: '',
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
      ...mapGetters('customer', {
        'customers': 'list'
      }),
      customerList () {
        return this.customers.map(item => {
          return {
            id: item.id,
            name: item.name
          }
        })
      }
    },
    methods: {
      back () {
        this.$router.go(-1)
      },
      update () {
        this.$store.dispatch('shop/update', this.shop).then(res => {
          this.$router.push({name: 'shops', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot update shop');
        })
      },
      create () {
        this.$store.dispatch('shop/create', this.shop).then(res => {
          this.$router.push({name: 'shops'})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create shop');
        })
      },
      handleSubmit () {
        this.isUpdate ? this.update() : this.create()
      }
    }
  }
</script>

<style scoped>

</style>
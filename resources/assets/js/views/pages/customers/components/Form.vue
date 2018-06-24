<template lang="pug">
  el-row
    el-col(:span="4")
      img(:src="logo_img" style="width: 100%" height="230")
      div(style="text-align: center; margin-top: 10px;")
        el-button(type="success") Thay đổi
    el-col(:span="20")
      el-form(ref="form" v-model="customer")
        el-col(:span="24")
          el-form-item
            el-input(v-model="customer.code" :disabled="isUpdate" placeholder="Mã khách hàng")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.first_name" placeholder="Tên")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.last_name" placeholder="Họ")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.phone" placeholder="Điện thoại")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.name" placeholder="Tên đăng nhập")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.password" v-if="!isUpdate" type="password" placeholder="Mật khẩu")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.email" v-if="!isUpdate" type="email" placeholder="Email")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.address" placeholder="Địa chỉ")
        el-col(:span="6")
          el-form-item
            el-select(v-model="customer.employee_id" clearable placeholder="Nhân viên" style="width: 100%")
              el-option(v-for="item in employeesList" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="6")
          el-form-item
            el-select(v-model="customer.customer_type" clearable placeholder="Loại khách hàng" style="width: 100%")
              el-option(label="Vip" value="1")
              el-option(label="Thường" value="2")
        el-col(:span="24")
          administrative-select(v-model="customer.selectedProvince")
        el-col(:span="24")
          el-form-item(style="margin: 0 10px")
            el-checkbox(label="Online activities")
        el-col(:span="24")
          el-form-item(style="margin: 0 10px")
            el-checkbox(label="Active")
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
      customer: {
        type: Object,
        default: () => {
          return {
            code: '',
            first_name: '',
            last_name: '',
            name: '',
            phone: '',
            password: '',
            email: '',
            selectedProvince: {},
            customer_type: null,
            address: '',
            employee_id: null
          }
        }
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters('employee', {
        'employees': 'list'
      }),
      employeesList () {
        return this.employees.map(item => {
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
        this.$store.dispatch('customer/update', this.customer).then(res => {
          this.$router.push({name: 'customers', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot update customer');
        })
      },
      create () {
        this.$store.dispatch('customer/create', this.customer).then(res => {
          this.$router.push({name: 'customers'})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create customers');
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
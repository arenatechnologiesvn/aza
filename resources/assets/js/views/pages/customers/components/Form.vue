<template lang="pug">
  el-row
    el-col(:span="5" style="padding-right: 10px;")
      img(:src="selectedAvatarUrl()" style="width: 100%" height="230")
      div(style="text-align: center; margin-top: 10px;")
        el-button(type="success" @click="openMediaModal('single')" size="small") Thay đổi
    el-col(:span="19")
      el-form(ref="form" v-model="customer")
        el-col(:span="24")
          el-form-item
            el-input(v-model="customer.code" :disabled="isUpdate" placeholder="Mã khách hàng")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.first_name" clearable placeholder="Tên")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.last_name" clearable placeholder="Họ")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.phone" clearable placeholder="Điện thoại")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.name" clearable placeholder="Tên đăng nhập")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.password" clearable v-if="!isUpdate" type="password" placeholder="Mật khẩu")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.email" clearable v-if="!isUpdate" type="email" placeholder="Email")
        el-col(:span="12")
          el-form-item
            el-input(v-model="customer.address" clearable placeholder="Địa chỉ")
        el-col(:span="6")
          el-form-item
            el-select(v-model="customer.employee_id" clearable placeholder="Nhân viên" style="width: 100%")
              el-option(v-for="item in employeesList" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="6")
          el-form-item
            el-select(v-model="customer.customer_type" clearable placeholder="Loại khách hàng" style="width: 100%")
              el-option(label="Vip" :value="1")
              el-option(label="Thường" :value="0")
        el-col(:span="24")
          administrative-select(v-model="customer.selectedProvince")
        el-col(:span="24")
          el-form-item
            el-checkbox(v-model="customer.is_active" label="Kích hoạt")
        el-col(:span="24")
          el-form-item(style="text-align: right;")
            el-button(type="primary" @click="handleSubmit")
              svg-icon(icon-class="fa-solid save")
              span(style="margin-left: 10px") Lưu
            el-button(type="danger" @click="back")
              svg-icon(icon-class="fa-solid ban")
              span(style="margin-left: 10px") Hủy bỏ
      media-manager-modal(type="user")
</template>

<script>
  import MediaManagerModal from '~/components/MediaManager/modal';
  import dummyImage from '~/assets/login_images/dummy-image.jpg';
  import AdministrativeSelect from '~/components/AdministrativeSelect'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    name: 'EmployeeForm',
    components: {
      AdministrativeSelect,
      MediaManagerModal
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
            employee_id: null,
            avatar: null
          }
        }
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters('employees', {
        employees: 'list'
      }),
      ...mapGetters('media', {
        selectedAvatar: 'selectedSingleMedia',
      }),
      employeesList () {
        return this.employees.filter(item => item.role_id === 3).map(item => {
          return {
            id: item.id,
            name: item.full_name
          }
        })
      }
    },
    methods: {
      ...mapActions('employees', {
        fetchEmployees: 'fetchList'
      }),
      ...mapActions('customers', {
        createCustomer: 'create',
        updateCustomer: 'update'
      }),
      ...mapActions('common', {
        openMediaModal: 'openMediaManagerModal'
      }),
      back () {
        this.$router.go(-1)
      },
      update () {
        this.updateCustomer({
          id: this.$route.params.id,
          data: this.customer
        }).then(res => {
          this.$router.push({name: 'customers', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot update customer');
        })
      },
      create () {
        this.createCustomer({
          data: this.customer
        }).then(res => {
          this.$router.push({name: 'customers'})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create customers');
        })
      },
      handleSubmit () {
        this.isUpdate ? this.update() : this.create()
      },
      selectedAvatarUrl() {
        return this.customer.avatar ? this.customer.avatar.url : dummyImage;
      }
    },
    watch: {
      selectedAvatar() {
        if (this.selectedAvatar) {
          this.customer.avatar = this.selectedAvatar;
        }
      }
    },
    created () {
      this.fetchEmployees()
    }
  }
</script>

<style scoped>

</style>
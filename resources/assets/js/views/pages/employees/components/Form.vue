<template lang="pug">
  el-row
    el-col(:span="4")
      img(:src="logo_img" style="width: 100%" height="230")
      div(style="text-align: center; margin-top: 10px;")
        el-button(type="success") Thay đổi
    el-col(:span="20")
      el-form(ref="form" v-model="employee")
        el-col(:span="24")
          el-form-item
            el-input(v-model="employee.code" :disabled="isUpdate" placeholder="Mã nhân viên")
        el-col(:span="12")
          el-form-item
            el-input(v-model="employee.first_name" placeholder="Tên")
        el-col(:span="12")
          el-form-item
            el-input(v-model="employee.last_name" placeholder="Họ")
        el-col(:span="12")
          el-form-item
            el-input(v-model="employee.phone" placeholder="Điện thoại")
        el-col(:span="12")
          el-form-item
            el-input(v-model="employee.name" placeholder="Tên đăng nhập")
        el-col(:span="12")
          el-form-item
            el-input(v-model="employee.password" v-if="!isUpdate" type="password" placeholder="Mật khẩu")
        el-col(:span="12")
          el-form-item
            el-input(v-model="employee.email" v-if="!isUpdate" type="email" placeholder="Email")
        el-col(:span="12")
          el-form-item
            el-date-picker(v-model="employee.start_datetime" type="date" placeholder="Ngày ký hợp đồng" style="width: 100%")
        el-col(:span="12")
          el-form-item
            el-select(v-model="employee.role_id" clearable placeholder="Vai trò" style="width: 100%")
              el-option(v-for="item in roleList" :key="item.id" :label="item.value" :value="item.id")
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
  import { mapGetters } from 'vuex'
  import logo_img from '~/assets/login_images/linh-nguyen.jpg'

  export default {
    name: 'EmployeeForm',
    data () {
      return {
        logo_img
      }
    },
    props: {
      employee: {
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
            role_id: '',
            start_datetime: null
          }
        }
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters('role', {
        'roles': 'list'
      }),
      roleList () {
        return this.roles.map(item => {
          return {
            id: item.id,
            value: item.description
          }
        })
      }
    },
    methods: {
      back () {
        this.$router.go(-1)
      },
      update () {
        this.$store.dispatch('employee/update', this.employee).then(res => {
          this.$router.push({name: 'employees', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot update employee');
        })
      },
      create () {
        this.$store.dispatch('employee/create', this.employee).then(res => {
          this.$router.push({name: 'employees'})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create employee');
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
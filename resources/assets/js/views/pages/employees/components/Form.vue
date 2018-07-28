<template lang="pug">
  el-row
    media-manager-modal(type="user")
    el-col(:span="5" style="padding-right: 20px;")
      img(:src="avatarUrl()" style="width: 100%" height="230")
      div(style="text-align: center; margin-top: 10px;")
        el-button(type="success" @click="openMediaModal('single')") Thay đổi
    el-col(:span="19")
      el-form(ref="form" v-model="employee" size="small")
        el-col(:span="24")
          el-form-item(label="MÃ NHÂN VIÊN")
            el-input(v-model="employee.code" :disabled="isUpdate" placeholder="Mã nhân viên" clearable)
        el-col(:span="12")
          el-form-item(label="TÊN")
            el-input(v-model="employee.user.first_name" placeholder="Tên" clearable)
        el-col(:span="12")
          el-form-item(label="HỌ")
            el-input(v-model="employee.user.last_name" placeholder="Họ" clearable)
        el-col(:span="12")
          el-form-item(label="SỐ ĐIỆN THOẠI")
            el-input(v-model="employee.user.phone" placeholder="Điện thoại" clearable)
        el-col(:span="12")
          el-form-item(label="TÊN ĐĂNG NHẬP")
            el-input(v-model="employee.user.name" v-bind:disabled="isUpdate" placeholder="Tên đăng nhập" clearable)
        el-col(:span="12" v-show="!isUpdate")
          el-form-item(label="MẬT KHẨU")
            el-input(v-model="employee.user.password" type="password" placeholder="Mật khẩu" clearable)
        el-col(:span="isUpdate? 24 : 12")
          el-form-item(label="THƯ ĐIỆN TỬ")
            el-input(v-model="employee.user.email" v-bind:disabled="isUpdate" type="email" placeholder="Email" clearable)
        el-col(:span="12")
          el-form-item(label="NGÀY KÝ HỢP ĐỒNG")
            el-date-picker(v-model="employee.start_datetime" value-format="MM-dd-YYYY" type="date" placeholder="Ngày ký hợp đồng" style="width: 100%" clearable)
        el-col(:span="12")
          el-form-item(label="VAI TRÒ")
            el-select(v-model="employee.user.role_id" clearable placeholder="Vai trò" style="width: 100%")
              el-option(v-for="item in roleList" :key="item.id" :label="item.value" :value="item.id")
        el-col(:span="24")
          el-form-item
            el-checkbox(label="Kích hoạt" v-model="employee.user.is_active === 1")
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
  import { mapGetters, mapActions} from 'vuex'
  import MediaManagerModal from '~/components/MediaManager/modal';
  import dummyImage from '~/assets/login_images/dummy-image.jpg';

  export default {
    name: 'EmployeeForm',
    components: {
      MediaManagerModal
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
            user: {},
            avatar: null,
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
      ...mapGetters('roles', {
        roles: 'list'
      }),
      ...mapGetters({
        selectedAvatar: 'media/selectedSingleMedia'
      }),
      roleList () {
        return this.roles.filter(item => item.is_employee).map(item => {
          return {
            id: item.id,
            value: item.description
          }
        })
      }
    },
    methods: {
      back () {
        this.$router.push({ path: '/employees' });
      },
      ...mapActions('roles', {
        fetchRoles: 'fetchList'
      }),
      ...mapActions('employees', {
        employeeCreate: 'create',
        employeeUpdate: 'update'
      }),
      ...mapActions('common', {
        openMediaModal: 'openMediaManagerModal'
      }),
      update () {
        this.employeeUpdate({
          id: this.$route.params.id,
          data: this.employee
        }).then(res => {
          this.$router.push({name: 'employee_index', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot update employee');
        })
      },
      create () {
        this.employeeCreate({
          data: this.employee
        }).then(res => {
          this.$router.push({name: 'employee_index', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create employee');
        })
      },
      handleSubmit () {
        this.isUpdate ? this.update() : this.create()
      },
      avatarUrl() {
        return this.employee.avatar ? this.employee.avatar.url : dummyImage;
      }
    },
    watch: {
      selectedAvatar() {
        if (this.selectedAvatar) {
          this.employee.avatar = this.selectedAvatar;
        }
      }
    },
    created () {
      this.fetchRoles()
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  el-row
    el-col.side-form(:span="5")
      el-row.image-container
        img.image-preview(:src="avatarUrl()" width="100%")
      el-row(style="margin-top: 10px")
        el-button(type="success" size="small" @click="openMediaModal('single')") Thay đổi
    el-col(:span="19")
      el-form(ref="form" v-model="employee" size="small")
        el-col(:span="24")
          el-form-item(label="MÃ NHÂN VIÊN")
            el-input(v-model="employee.code" :disabled="isUpdate" placeholder="Mã nhân viên" clearable)
        el-col(:span="24")
          el-form-item(label="EMAIL")
            el-input(v-model="employee.user.email" v-bind:disabled="isUpdate" type="email" placeholder="Email" clearable)
        el-col(:span="24")
          el-form-item(label="TÊN ĐĂNG NHẬP")
            el-input(v-model="employee.user.name" v-bind:disabled="isUpdate" placeholder="Tên đăng nhập" clearable)
        el-col(:span="12")
          el-form-item(label="HỌ")
            el-input(v-model="employee.user.last_name" placeholder="Họ" clearable)
        el-col(:span="12")
          el-form-item(label="TÊN")
            el-input(v-model="employee.user.first_name" placeholder="Tên" clearable)
        el-col(:span="24")
          el-form-item(label="ĐỊA CHỈ")
            el-input(v-model="employee.user.address" placeholder="Địa chỉ" clearable)
        el-col(:span="24")
          el-form-item(label="SỐ ĐIỆN THOẠI")
            el-input(v-model="employee.user.phone" placeholder="Điện thoại" clearable)
        el-col(:span="12")
          el-form-item(label="VAI TRÒ")
            el-select(v-model="employee.user.role_id" clearable placeholder="Vai trò" style="width: 100%")
              el-option(v-for="item in roleList" :key="item.id" :label="item.value" :value="item.id")
        el-col(:span="12")
          el-form-item(label="NGÀY KÝ HỢP ĐỒNG")
            el-date-picker(v-model="employee.contract_at" format="dd-MM-yyyy" value-format="dd-MM-yyyy" type="date" placeholder="Ngày ký hợp đồng" style="width: 100%" clearable)
        el-col(:span="24")
          el-form-item
            el-checkbox(label="Kích hoạt" v-model="employee.user.is_active")
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
  import { mapGetters, mapActions } from 'vuex'
  import MediaManagerModal from '~/components/MediaManager/modal';
  import dummyImage from '~/assets/login_images/dummy-avatar.png';

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
            user: {
              avatar: [],
              email: '',
              name: '',
              first_name: '',
              last_name: '',
              phone: '',
              address: '',
              role_id: '',
              is_active: ''
            },
            contract_at: ''
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
      update (params) {
        this.employeeUpdate({
          id: this.$route.params.id,
          data: params
        }).then(res => {
          this.$router.push({name: 'employee_index', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot update employee');
        })
      },
      create (params) {
        this.employeeCreate({
          data: params
        }).then(res => {
          this.$router.push({name: 'employee_index', replace: true})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create employee');
        })
      },
      handleSubmit () {
        const params = this.prepareParams();
        this.isUpdate ? this.update(params) : this.create(params);
      },
      prepareParams() {
        const params = {
          user: {
            avatar: this.employee.user.avatar.length ? this.employee.user.avatar[0].id : null,
            first_name: this.employee.user.first_name,
            last_name: this.employee.user.last_name,
            phone: this.employee.user.phone,
            address: this.employee.user.address,
            role_id: this.employee.user.role_id,
            is_active: this.employee.user.is_active,
          },
          contract_at: this.employee.contract_at
        }

        if (!this.isUpdate) {
          params.code = this.employee.code;
          params.user.email = this.employee.user.email;
          params.user.name = this.employee.user.name;
        }

        return params;
      },
      avatarUrl() {
        return this.employee.user.avatar && this.employee.user.avatar.length ? this.employee.user.avatar[0].url : dummyImage;
      }
    },
    watch: {
      selectedAvatar() {
        if (this.selectedAvatar) {
          this.employee.user.avatar = [this.selectedAvatar];
        }
      }
    },
    created () {
      this.fetchRoles()
    }
  }
</script>

<style lang="scss" scoped>
.side-form {
  text-align: center;
  padding-right: 10px;

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
<template lang="pug">
  el-form(:model="form" ref="form" status-icon label-width="150px" :rules="rules" size="small")
    el-form-item(label="TÊN" prop="first_name")
      el-input(v-model="form.first_name" placeholder="Tên")
    el-form-item(label="HỌ" prop="last_name")
      el-input(v-model="form.last_name" placeholder="Họ")
    el-form-item(label="ĐIỆN THOẠI" prop="phone")
      el-input(v-model="form.phone" placeholder="Số điện thoại")
    el-form-item(label="NGÀY SINH" prop="birthday")
      el-date-picker(v-model="form.user_detail.birthday" type="date" value-format="dd-MM-yyyy" format="dd-MM-yyyy" placeholder="Ngày sinh")
    el-form-item(label="GIỚI TÍNH" prop="sex")
      el-radio-group(v-model="form.user_detail.sex")
        el-radio(:label="'0'") Nam
        el-radio(:label="'1'") Nữ
    el-form-item(label="ĐỊA CHỈ" prop="address")
      el-input(v-model="form.address" type="textarea" rows="3" placeholder="Địa chỉ")
    el-form-item(style="text-align: right")
      el-button(type="success" @click="onUpdate") CẬP NHẬT
</template>

<script>
  import http from '~/utils/request'
  import moment from 'moment'

  export default {
    name: 'ProfileInfo',
    data () {
      return {
        form: {
          id: '',
          first_name: '',
          last_name: '',
          phone: '',
          user_detail: {
            birthday: 0,
            sex: '0'
          },
          address: ''
        },
        rules: {
          first_name: [
            { required: true, message: 'Tên không được trống', trigger: 'blur' },
            { max: 50, message: 'Tên phải nhỏ hơn 50 ký tự', trigger: 'blur' }
          ],
          last_name: [
            { required: true, message: 'Họ không được trống', trigger: 'blur' },
            { max: 50, message: 'Họ phải nhỏ hơn 50 ký tự', trigger: 'blur' }
          ],
          phone: [
            { required: true, message: 'Điện thoại không được trống', trigger: 'blur' },
            { max: 20, message: 'Điện thoại phải nhỏ hơn 20 ký tự', trigger: 'blur' }
          ],
          address: [
            { max: 255, message: 'Địa chỉ phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ],
          'user_detail.sex': [
            { required: true, message: 'Giới tính là trường bắt buộc', trigger: 'blur' }
          ],
        }
      }
    },
    watch: {
      $route: 'getInfo'
    },
    methods: {
      onUpdate () {
        this.$refs['form'].validate((valid) => {
          if (valid) {
            http({
              url: `/api/users/${this.form.id}`,
              method: 'put',
              data: this.form
            }).then(data => {
              this.$message({
                message: 'Cập nhật thông tin thành công',
                type: 'success'
              })
              this.$store.dispatch('user/GetInfo');
            }).catch(() => this.$message({
              message: 'Cập nhật thông tin thất bại',
              type: 'error'
            }))
          }
        })
      },
      getInfo () {
        http({
          url: '/api/profile',
          method: 'get'
        }).then(res => {
          const { data } = res;
          this.form = data
          if (this.form.user_detail) {
            this.form.user_detail.birthday = moment.unix(this.form.user_detail.birthday).format('DD-MM-YYYY');
            this.form.user_detail.sex = this.form.user_detail.sex + '';
          } else {
            this.form.user_detail = {
              birthday: moment().format('DD-MM-YYYY'),
              sex: '0'
            }
          }
        })
      }
    },
    created () {
      this.getInfo()
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
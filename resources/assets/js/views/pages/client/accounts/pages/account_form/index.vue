<template lang="pug">
  el-form(:model="form" ref="form" status-icon label-width="150px" :rules="rules")
    el-form-item(label="TÊN" prop="first_name")
      el-input(v-model="form.first_name" placeholder="FIRST NAME")
    el-form-item(label="HỌ" prop="last_name")
      el-input(v-model="form.last_name" placeholder="LAST NAME")
    el-form-item(label="SĐT" prop="phone")
      el-input(v-model="form.phone" placeholder="SĐT")
    el-form-item(label="NGÀY SINH" prop="birthday")
      el-date-picker(v-model="form.user_detail.birthday" type="date" placeholder="NGÀY SINH")
    el-form-item(label="GIỚI TÍNH" prop="sex")
      el-radio-group(v-model="form.user_detail.sex")
        el-radio(:label="'0'") Nam
        el-radio(:label="'1'") Nữ
    el-form-item(label="ĐỊA CHỈ" prop="address")
      el-input(v-model="form.address" type="textarea" rows="3" placeholder="ĐỊA CHỈ")
    el-form-item
      el-button(type="primary" @click="onUpdate") CẬP NHẬT
</template>

<script>
  import http from '~/utils/request'
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
          first_name: [{ required: true, message: 'Tên là bắt buộc', trigger: 'blur' }],
          last_name: [{required: true, message: 'Họ là bắt buộc', trigger: 'blur'}],
          phone: [{required: true, message: 'Số Điện thoại là bắt buộc', trigger: 'blur'}],
          address: [{required: true, message: 'Địa chỉ là bắt trường buộc', trigger: 'blur'}],
          'user_detail.sex': [{required: true, message: 'Giới tính là trường bắt buộc', trigger: 'blur'}],
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
              this.$message(
                {
                  message: 'Cập nhật thông tin thành công',
                  type: 'success'
                })
              this.$store.dispatch('GetInfo');
            }).catch(() => this.$message(
              {
                message: 'Lỗi khi cập nhật thông tin',
                type: 'warning'
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
          if(this.form.user_detail) {
            this.form.user_detail.birthday = new Date((+(this.form.user_detail.birthday))*1000)
            this.form.user_detail.sex = this.form.user_detail.sex + '';
          } else {
            this.form.user_detail = {
              birthday: new Date,
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

<style scoped>

</style>
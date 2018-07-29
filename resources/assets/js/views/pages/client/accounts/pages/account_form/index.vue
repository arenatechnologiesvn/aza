<template lang="pug">
  div {{customer}}
    el-form(ref="form" :model="form" label-width="150px")
      el-form-item(label="HỌ TÊN")
        el-input(v-model="form.name" placeholder="HỌ TÊN")
      el-form-item(label="SỐ ĐIỆN THOẠI")
        el-input(v-model="form.phone" placeholder="SỐ ĐIỆN THOẠI")
      el-form-item(label="GIỚI TÍNH")
        el-radio-group(v-model="form.sex" placeholer="GIỚI TÍNH")
          el-radio(:label="0") Nam
          el-radio(:label="1") Nữ
      el-form-item(label="ĐỊA CHỈ NHẬN HÀNG")
        el-input(type="textarea" v-model="form.address" placeholder="ĐỊA CHỈ NHẬN HÀNG")
      el-form-item
        el-button(type="success" @click="updateData") CẬP NHẬT
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  export default {
    name: 'Account',
    data () {
      return {
        form: {
          id: 0,
          name: '',
          phone: '',
          address: '',
          sex: false
        }
      }
    },
    computed: {
      ...mapGetters([
        'user_info'
      ]),
      customer () {
        const user = this.user_info
          this.form.id = user.customer ? user.customer.id : 0,
          this.form.name = `${user.first_name} ${user.last_name}`,
          this.form.phone = user.phone,
          this.form.address = user.customer ? user.customer.address : '',
          this.form.sex = user.customer.sex
      }
    },
    methods: {
      ...mapActions('customers', {
        updateCustomer: 'update'
      }),
      updateData () {
        console.log(this.customer);
        this.updateCustomer({
          id: this.form.id,
          data: this.form
        }).then(res => {
          this.$notify({
            title: 'Thông báo cập nhật',
            message: 'Cập nhật tài khoản thành công',
            type: 'success'
          });
        }).catch(err => {
          console.log(err);
          this.$notify({
            title: 'Thông báo cập nhật',
            message: 'Lỗi cập nhật thông tin',
            type: 'warning'
          });
        })
      }
    }

  }
</script>
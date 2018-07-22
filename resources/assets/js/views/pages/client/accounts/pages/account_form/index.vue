<template lang="pug">
  div
    el-form(ref="form" :model="customer" label-width="150px")
      el-form-item(label="HỌ TÊN")
        el-input(v-model="customer.name" placeholder="HỌ TÊN")
      el-form-item(label="SỐ ĐIỆN THOẠI")
        el-input(v-model="customer.phone" placeholder="SỐ ĐIỆN THOẠI")
      el-form-item(label="GIỚI TÍNH")
        el-radio-group(v-model="customer.sex" placeholer="GIỚI TÍNH")
          el-radio(label="Nam" )
          el-radio(label="Nữ")
      el-form-item(label="ĐỊA CHỈ NHẬN HÀNG")
        el-input(type="textarea" v-model="customer.address" placeholder="ĐỊA CHỈ NHẬN HÀNG")
      el-form-item
        el-button(type="success" @click="updateData") CẬP NHẬT
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  export default {
    name: 'Account',
    computed: {
      ...mapGetters([
        'user_info'
      ]),
      customer () {
        const user = this.user_info
        return {
          id: user.customer ? user.customer.id : 0,
          name: `${user.first_name} ${user.last_name}`,
          phone: user.phone,
          address: user.customer ? user.customer.address : '',
          sex: false
        }
      }
    },
    methods: {
      ...mapActions('customers', {
        updateCustomer: 'update'
      }),
      updateData () {
        console.log(this.customer);
        this.updateCustomer({
          id: this.customer.id,
          data: this.customer
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
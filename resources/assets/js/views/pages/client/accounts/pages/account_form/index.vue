<template lang="pug">
  div
    el-form(ref="form" :model="form" label-width="150px")
      el-form-item(label="HỌ TÊN")
        el-input(v-model="form.name" placeholder="HỌ TÊN")
      el-form-item(label="SỐ ĐIỆN THOẠI")
        el-input(v-model="form.phone" placeholder="SỐ ĐIỆN THOẠI")
      el-form-item(label="GIỚI TÍNH")
        el-radio-group(v-model="form.sex" placeholer="GIỚI TÍNH")
          el-radio(label="Nam")
          el-radio(label="Nữ")
      el-form-item(label="ĐỊA CHỈ NHẬN HÀNG")
        el-input(type="textarea" v-model="form.address" placeholder="ĐỊA CHỈ NHẬN HÀNG")
      el-form-item
        el-button(type="success") CẬP NHẬT
</template>

<script>
  export default {
    name: 'Account',
    data() {
      return {
        form: {
          name: '',
          phone: '',
          sex: '',
          address: ''
        }
      }
    }
  }
</script>
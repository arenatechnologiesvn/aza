<template lang="pug">
  el-form(:model="form" ref="form" label-width="150px")
    el-form-item(label="MÃ NHÂN VIÊN")
      el-input(v-model="form.code" placeholder="MÃ NHÂN VIÊN")
    el-form-item(label="TÊN")
      el-input(v-model="form.first_name" placeholder="FIRST NAME")
    el-form-item(label="HỌ")
      el-input(v-model="form.last_name" placeholder="LAST NAME")
    el-form-item(label="SĐT")
      el-input(v-model="form.phone" placeholder="SĐT")
    el-form-item(label="NGÀY KÝ HỢP ĐỒNG")
      el-date-picker(v-model="form.contract_at" type="date" placeholder="NGÀY KÝ HỢP ĐỒNG")
    el-form-item(label="NGÀY SINH")
      el-date-picker(v-model="form.birthday" type="date" placeholder="NGÀY SINH")
    el-form-item(label="GIỚI TÍNH")
      el-radio-group(v-model="form.sex")
        el-radio(:label="0") Nam
        el-radio(:label="1") Nữ
    el-form-item(label="ĐỊA CHỈ")
      el-input(v-model="form.address" type="textarea" rows="3" placeholder="ĐỊA CHỈ")
    el-form-item
      el-button(type="primary" @click="onUpdate") CẬP NHẬT
</template>

<script>
  import http from '~/utils/request'
  import { mapActions } from 'vuex'
  export default {
    name: 'ProfileInfo',
    data () {
      return {
        form: {
          id: '',
          code: '',
          first_name: '',
          last_name: '',
          phone: '',
          contract_at: '',
          birthday: '',
          sex: 1
        }
      }
    },
    watch: {
      $route: 'getInfo'
    },
    methods: {
      ...mapActions('employees', {
        updateEmployee: 'update'
      }),
      onUpdate () {
        this.updateEmployee({
          id: this.form.id,
          data: this.form
        }).then(data => {
          console.log(data)
        })
      },
      getInfo () {
        http({
          url: '/api/profile',
          method: 'get'
        }).then(res => {
          const { data } = res;
          this.form.id = data.id;
          this.form.code = data.code
          this.form.first_name = data.user.first_name;
          this.form.last_name = data.user.last_name;
          this.form.phone = data.user.phone;
          this.form.contract_at = new Date(+data.contract_at * 1000);
          this.form.birthday = data.user.user_detail ? new Date(+data.user.user_detail.birth_day * 1000 ): '';
          this.form.sex = data.user.user_detail ? data.user.user_detail.sex: 0;
          this.form.address = data.user.address
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
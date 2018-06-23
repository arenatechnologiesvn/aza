<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid user-plus")
        span(style="margin-left: 10px;") Thêm mới khách hàng
      el-dropdown(style="float: right; padding-right: 7px; cursor: pointer;")
        span.el-dropdown-link
          svg-icon(icon-class="fa-solid cog")
          i(class="el-icon-arrow-down el-icon--right")
        el-dropdown-menu(slot="dropdown")
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid shopping-basket")
              span(style="margin-left: 5px;") Thêm mới cửa hàng
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid hand-pointer")
              span(style="margin-left: 5px;") Thêm mới loại khách hàng
    el-row
      el-col(:span="4")
        img(:src="logo_img" style="width: 100%" height="230")
        div(style="text-align: center; margin-top: 10px;")
          el-button(type="success") Thay đổi
      el-col(:span="20")
        el-form(ref="form" v-model="form")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.fullName" placeholder="Họ tên")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.phone" placeholder="Điện thoại")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.username" placeholder="Tên đăng nhập")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.password" type="password" placeholder="Mật khẩu")
          el-col(:span="12")
            el-form-item
              el-input(v-model="form.email" type="email" placeholder="Email")
          el-col(:span="6")
            el-form-item
              el-select(v-model="form.employee_id" clearable placeholder="Nhân viên" style="width: 100%")
                el-option(label="Vip" value="1")
                el-option(label="Thường" value="2")
          el-col(:span="6")
            el-form-item
              el-select(v-model="form.type" clearable placeholder="Loại khách hàng" style="width: 100%")
                el-option(label="Vip" value="1")
                el-option(label="Thường" value="2")
          el-col(:span="24")
            el-form-item(style="margin: 0 10px")
              el-checkbox(label="Online activities")
          el-col(:span="24")
            el-form-item(style="margin: 0 10px")
              el-checkbox(label="Active")
          el-col(:span="24")
            el-form-item(style="text-align: right;")
              el-button(type="primary")
                svg-icon(icon-class="fa-solid save")
                span(style="margin-left: 10px") Lưu
              el-button(type="danger")
                svg-icon(icon-class="fa-solid ban")
                span(style="margin-left: 10px") Hủy bỏ
</template>
<script>
  import { mapGetters } from 'vuex'
  import logo_img from '~/assets/login_images/linh-nguyen.jpg'
  import ElCard from "element-ui/packages/card/src/main";

  export default {
    components: {ElCard},
    name: 'UserForm',
    computed: {
      ...mapGetters([
        'avatar'
      ])
    },
    data () {
      return {
        logo_img,
        form: {
          fullName: '',
          phone: '',
          email:'',
          role_id: 1,
          type: ''
        }
      }
    }
  }
</script>

<style>
 .el-form-item {
   margin: 10px;
 }
</style>
<template lang="pug">
  div.top
    div.container
      div.top__left
        svg-icon(icon-class="fa-solid mobile-alt")
        span Tải Aza App - Ưu đãi ngay trên tay
      div.top__right
        ul.unstyle
          li
            el-dropdown.top__dropdown(style="z-index=99999999;")
              div.top__alert
                el-badge(:value="10" class="item")
                  svg-icon(icon-class="fa-solid bell")
                span Thông báo
              el-dropdown-menu(slot="dropdown")
                el-dropdown-item Item 1
                el-dropdown-item Item 2
          li
            el-dropdown.top__dropdown
              div.avatar__container
                img.avatar(:src="avatar")
                span Kelvin Hiếu
                i.el-icon-caret-bottom(style="margin-left: 5px")
              el-dropdown-menu(slot="dropdown")
                el-dropdown-item
                  router-link(to="/home/accounts")
                    svg-icon(icon-class="fa-solid user")
                    span Thông tin tài khoản
                el-dropdown-item
                  router-link(to="/home/accounts")
                    svg-icon(icon-class="fa-solid cart-arrow-down")
                    span Lịch sử đơn hàng
                el-dropdown-item
                  router-link(to="/home/accounts")
                    svg-icon(icon-class="fa-solid sign-out-alt")
                    span Đăng xuất
</template>

<script>
  import avatar from '~/assets/login_images/linh-nguyen.jpg'
  import ElBadge from "element-ui/packages/badge/src/main";
  export default {
    components: {ElBadge},
    name: 'NavbarTop',
    data () {
      return {
        avatar
      }
    }
  }
</script>

<style scoped>

</style>
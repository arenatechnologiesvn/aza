<template lang="pug">
  div.top
    div.container
      div.top__left
        a(href="#")
          svg-icon(icon-class="fa-solid mobile-alt")
          span Tải Aza App
          span(class="hidden-sm-and-down") - Ưu đãi ngay trên tay
      div.top__right
        ul.unstyle
          li
            el-dropdown.top__dropdown(style="z-index=99999999;")
              div.top__alert
                el-badge(:value="10" class="item")
                  svg-icon(icon-class="fa-solid bell")
                span(class="hidden-sm-and-down") Thông báo
              el-dropdown-menu(slot="dropdown")
                el-dropdown-item Item 1
                el-dropdown-item Item 2
          li
            el-dropdown.top__dropdown
              div.avatar__container
                img.avatar(:src="user_info.avatar")
                span.hidden-sm-and-down {{user_info.last_name + ' ' + user_info.first_name}}
                i.el-icon-caret-bottom(style="margin-left: 5px")
              el-dropdown-menu(slot="dropdown" trigger="click")
                el-dropdown-item(v-if="user_info.role_name === 'Admin'")
                  router-link(to="/")
                    svg-icon(icon-class="fa-solid tachometer-alt")
                    span Trang quản lý
                el-dropdown-item
                  router-link(to="/home/accounts")
                    svg-icon(icon-class="fa-solid user")
                    span Thông tin tài khoản
                el-dropdown-item
                  router-link(to="/home/accounts/favorite")
                    svg-icon(icon-class="fa-solid heart")
                    span Sản phẩm yêu thích
                el-dropdown-item
                  router-link(to="/home/accounts/order")
                    svg-icon(icon-class="fa-solid cart-arrow-down")
                    span Lịch sử đơn hàng
                el-dropdown-item(divided)
                  span(@click="logout" style="display:block;")
                    svg-icon(icon-class="fa-solid sign-out-alt")
                    span Đăng xuất
</template>

<script>
  import avatar from '~/assets/login_images/linh-nguyen.jpg'
  import ElBadge from "element-ui/packages/badge/src/main";
  import { mapGetters } from 'vuex'
  export default {
    components: {ElBadge},
    name: 'NavbarTop',
    computed: {
      ...mapGetters([
        'user_info'
      ])
    },
    data () {
      return {
        avatar
      }
    },
    methods: {
      logout () {
        this.$store.dispatch('LogOut').then(() => {
          this.$router.push({path: '/'})
          location.reload()
        })
      }
    }
  }
</script>
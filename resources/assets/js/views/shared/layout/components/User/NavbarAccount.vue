<template lang="pug">
  div.header-account
    el-badge.header-account__alert(:value="10" class="item")
      svg-icon(icon-class="fa-solid bell")
    el-dropdown(trigger="click")
      div.header-account__control
        img.user__avatar(:src="avatar")
        span Ngoc Xuân
        i.el-icon-caret-bottom
      el-dropdown-menu.header-account__dropdown(slot="dropdown")
        el-dropdown-item
          router-link(class="inlineBlock" to="/")
            svg-icon(icon-class="fa-solid user")
            span(style="margin-left: 5px") Thông tin cá nhân
        el-dropdown-item(divided)
        el-dropdown-item
          router-link(class="inlineBlock" to="/")
            svg-icon(icon-class="fa-solid cog")
            span(style="margin-left: 5px") Cài đặt
        el-dropdown-item
          span(style="display:block;")
            svg-icon(icon-class="fa-solid lock")
            span(style="margin-left: 5px") Đăng xuất
</template>

<script>
  import './navbar_account.scss'
  export default {
    name: 'NavbarAccount',
    props: {
      avatar: String
    }
  }
</script>

<style scoped>

</style>
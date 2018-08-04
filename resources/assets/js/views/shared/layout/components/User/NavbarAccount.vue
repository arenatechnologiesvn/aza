<template lang="pug">
  div.header-account
    // el-badge.header-account__alert(:value="10" class="item")
    //   svg-icon(icon-class="fa-solid bell")
    el-dropdown(trigger="click")
      div.header-account__control
        img.user__avatar(:src="avatarUrl()" style="border-radius: 50%;")
        span {{(info.full_name.length > 5 && info.full_name) || info.name}}
        i.el-icon-caret-bottom
      el-dropdown-menu.header-account__dropdown(slot="dropdown")
        el-dropdown-item
          router-link(class="inlineBlock" to="/profile")
            svg-icon(icon-class="fa-solid user")
            span(style="margin-left: 5px") Thông tin cá nhân
        el-dropdown-item(divided)
        el-dropdown-item
          router-link(class="inlineBlock" :to="`/setting/${info.id}`")
            svg-icon(icon-class="fa-solid cog")
            span(style="margin-left: 5px") Cài đặt
        el-dropdown-item
          span(style="display:block;" @click="logout")
            svg-icon(icon-class="fa-solid lock")
            span(style="margin-left: 5px") Đăng xuất
</template>

<script>
  import './navbar_account.scss'
  import dummyImage from '~/assets/login_images/dummy-avatar.png'

  export default {
    name: 'NavbarAccount',
    props: {
      info: {
        type: Object,
        default: () => {}
      }
    },
    methods: {
      logout () {
        this.$store.dispatch('LogOut').then(() => {
          this.$router.push({name: 'login'})
        })
      },

      avatarUrl() {
        if (this.info.avatar && this.info.avatar.length) return this.info.avatar[0].url;
        return dummyImage;
      }
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div.profile-container
    el-tabs(type="border-card")
      el-tab-pane
        span(slot="label")
          svg-icon(icon-class="fa-solid user")
          span.pane--title Thông tin cá nhân
        div
          profile-info
      el-tab-pane
        span(slot="label")
          svg-icon(icon-class="fa-solid lock")
          span.pane--title Thay đổi mật khẩu
        div Password
      el-tab-pane
        span(slot="label")
          svg-icon(icon-class="fa-solid history")
          span.pane--title Lịch sửa thao tác
        div Lich Sử thao tác
</template>

<script>
  import ProfileInfo from './components/Profile/Info'
  export default {
    components: {
      ProfileInfo
    },
    name: 'Personal'
  }
</script>

<style scoped>
  span.pane--title {
    margin-left: 7px;
  }
</style>
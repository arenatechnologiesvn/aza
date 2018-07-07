<template lang="pug">
  div.account-nav
    div.account-nav__avatar
      div.avatar__img
        img(:src="avatar")
      div.avatar__info
        h4.info__name LINH NGUYỄN
        div
          strong.info__vip VIP
        div
          span.info__score
            span.score 400
            svg-icon(icon-class="fa-solid coins")
    ul
      li
        router-link(to="/home/accounts")
          svg-icon(icon-class="fa-solid user")
          span TÀI KHOẢN CỦA TÔI
      li
        router-link(to="/home/accounts/alert")
          svg-icon(icon-class="fa-solid bell")
          span THÔNG BÁO CỦA TÔI
      li
        router-link(to="/home/accounts")
          svg-icon(icon-class="fa-solid cart-arrow-down")
          span QUẢN LÝ ĐƠN HÀNG
      li
        router-link(to="/home/accounts")
          svg-icon(icon-class="fa-solid heart")
          span SẢN PHẨM YÊU THÍCH
      li
        router-link(to="/home/accounts")
          svg-icon(icon-class="fa-solid sign-out-alt")
          span ĐĂNG XUẤT
</template>

<script>
  import avatar from '~/assets/products/linh-nguyen.jpg'
  import './nav.scss'
  export default {
    name: 'NavAccount',
    data () {
      return {
        avatar
      }
    }
  }
</script>

<style scoped>

</style>
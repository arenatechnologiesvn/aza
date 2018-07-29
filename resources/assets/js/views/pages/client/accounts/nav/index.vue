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
      li(v-for="menu in menus" :key="menu.name" :class="{'active': $route.name === menu.name}")
        router-link(:to="menu.path")
          svg-icon(:icon-class="menu.icon")
          span {{menu.title}}
          span(v-if="menu.count && menu.count > 0" style="float: right; position: relative; top: 4px; right: 7px")
            el-badge(:value="menu.count" class="item")
</template>

<script>
  import './nav.scss'
  export default {
    components: {},
    name: 'NavAccount',
    computed: {
      avatar () {
        return this.$store.getters.user_info.avatar
      }
    },
    props: {
      menus: {
        type: Array,
        default: () => [
          {
            name: 'home_account_index',
            path: '/home/accounts',
            title: 'TÀI KHOẢN CỦA TÔI',
            icon: 'fa-solid user'
          },
          {
            name: 'home_account_alert',
            path: '/home/accounts/alert',
            title: 'THÔNG BÁO CỦA TÔI',
            icon: 'fa-solid bell',
            count: 10
          },
          {
            name: 'home_account_order',
            path: '/home/accounts/order',
            title: 'QUẢN LÝ ĐƠN HÀNG',
            icon: 'fa-solid cart-arrow-down'
          },
          {
            name: 'home_account_favorite',
            path: '/home/accounts/favorite',
            title: 'SẢN PHẨM YÊU THÍCH',
            icon: 'fa-solid heart'
          },
          {
            name: 'home_account_logout',
            path: '/home/accounts',
            title: 'ĐĂNG XUẤT',
            icon: 'fa-solid sign-out-alt'
          }
        ]
      }
    }
  }
</script>
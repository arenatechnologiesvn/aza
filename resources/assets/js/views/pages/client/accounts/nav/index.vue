<template lang="pug">
  div.account-nav
    div.account-nav__avatar
      div.avatar__img
        img(:src="avatar")
      div.avatar__info
        h4.info__name {{$store.getters.user_info.full_name}}
        div
          strong.info__vip {{$store.getters.user_info.customer.customer_type === 0 ? 'THƯỜNG': 'VIP'}}
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
  import dummyImage from '~/assets/login_images/dummy-avatar.png'
  export default {
    components: {},
    name: 'NavAccount',
    computed: {
      avatar () {
        return this.$store.getters.user_info.avatar && this.$store.getters.user_info.avatar.length && this.$store.getters.user_info.avatar[0].url || dummyImage
      }
    },
    props: {
      menus: {
        type: Array,
        default: () => [
          {
            name: 'home_account_index',
            path: '/accounts',
            title: 'TÀI KHOẢN CỦA TÔI',
            icon: 'fa-solid user'
          },
          // {
          //   name: 'home_account_alert',
          //   path: '/accounts/alert',
          //   title: 'THÔNG BÁO CỦA TÔI',
          //   icon: 'fa-solid bell',
          //   count: 10
          // },
          {
            name: 'home_account_shop',
            path: '/accounts/shop',
            title: 'CỬA HÀNG CỦA TÔI',
            icon: 'fa-solid store-alt'
          },
          {
            name: 'home_account_order',
            path: '/accounts/order',
            title: 'QUẢN LÝ ĐƠN HÀNG',
            icon: 'fa-solid cart-arrow-down'
          },
          {
            name: 'home_account_favorite',
            path: '/accounts/favorite',
            title: 'SẢN PHẨM YÊU THÍCH',
            icon: 'fa-solid heart'
          }
        ]
      }
    }
  }
</script>
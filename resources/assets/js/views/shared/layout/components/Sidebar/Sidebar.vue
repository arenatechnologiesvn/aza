<template lang="pug">
  div.menu-sidebar__container
    slot(name="logo")
    el-scrollbar(wrapClass="scrollbar-wrapper" style="z-index: 99px;")
      sidebar-account(:collapse="collapse" :avatar="userLogo" :info="info")
      el-menu(:default-active="activeName"
        :unique-opened="accordion"
        :default-openeds="openedNames"
        class="el-menu-vertical-demo",
        text-color="#fff"
        :collapse="collapse"
        :collapse-transition="false"
        :router="true"
        @select="onSelect")
        template(v-for="item in menuList")
          sidebar-item(v-if="showChildren(item)" :key="`menu-${item.name}`" :parent-item="item")
          el-menu-item(v-else :index="`${item.name}`" :key="`menu-${item.name}`" :route="item")
            svg-icon(:icon-class="icon(item)")
            span(style="margin-left: 10px") {{showTitle(item)}}
</template>

<script>
  import './sidebar.scss'
  import SidebarItem from './SidebarItem'
  import SidebarAccount from './SidebarAccount'
  import userLogo from '~/assets/login_images/linh-nguyen.jpg'
  import Mixin from './mixin'

  export default {
    name: 'Sidebar',
    components: {
      SidebarItem,
      SidebarAccount
    },
    mixins: [Mixin],
    data () {
      return {
        userLogo,
        info: {
          role: 'ADMIN',
          description: 'Quản trị viên cao cấp'
        },
        openedNames: []
      }
    },
    props: {
      menuList: {
        type: Array,
        default: () => []
      },
      collapse: {
        type: Boolean
      },
      accordion: {
        type: Boolean,
        default: true
      },
      activeName: {
        type: String,
        default: ''
      },
      openNames: {
        type: Array,
        default: () => []
      }
    },
    methods: {
      onSelect (name) {
        this.$emit('on-select',name )
      }
    }
  }
</script>

<style scoped>

</style>
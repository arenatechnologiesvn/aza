<template lang="pug">
  el-scrollbar(wrapClass="scrollbar-wrapper")
    el-menu(
      mode="vertical"
      :show-timeout="200"
      :default-active="$route.path"
      :collapse="isCollapse"
      background-color="#001C2C"
      text-color="#bfcbd9"
      active-text-color="#409EFF"
    )
      sidebar-item(:routes="permission_routers")
</template>

<script>
import { mapGetters } from 'vuex'
import SidebarItem from './SidebarItem'

export default {
  components: { SidebarItem },
  computed: {
    ...mapGetters([
      'permission_routers',
      'sidebar'
    ]),
    isCollapse() {
      return !this.sidebar.opened
    }
  }
}
</script>

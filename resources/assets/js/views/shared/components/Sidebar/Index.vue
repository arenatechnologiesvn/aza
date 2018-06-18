<template lang="pug">
  el-scrollbar(wrapClass="scrollbar-wrapper")
    account
    sidebar-menu
</template>

<script>
  import Account from './Account'
  import SidebarMenu from './Menu'

  export default {
    name: 'Sidebar',
    components: {
      Account,
      SidebarMenu
    }
  }
</script>

<style scoped>

</style>
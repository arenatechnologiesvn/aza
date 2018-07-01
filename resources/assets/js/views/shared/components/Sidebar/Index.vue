<template lang="pug">
  el-scrollbar(wrapClass="scrollbar-wrapper")
    account
    sidebar-menu(:collapse="collapsed")
</template>

<script>
  import Account from './Account'
  import SidebarMenu from './Menu'

  export default {
    name: 'Sidebar',
    props: {
      collapsed: Boolean
    },
    components: {
      Account,
      SidebarMenu
    }
  }
</script>

<style scoped>

</style>
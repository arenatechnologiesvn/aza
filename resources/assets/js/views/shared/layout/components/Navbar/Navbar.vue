<template lang="pug">
  div.header-bar
    sider-trigger(:collapsed="collapsed" @on-change="handleCollapsedChange")
    bread-crumb(:list="listBreadcrumb")
    slot
</template>

<script>
  import SiderTrigger from './SiderTrigger'
  import BreadCrumb from './Breadcrumb'
  export default {
    name: 'Navbar',
    components: {
      SiderTrigger,
      BreadCrumb
    },
    props: {
      collapsed: Boolean,
      listBreadcrumb: Array
    },
    methods: {
      handleCollapsedChange (state) {
        this.$emit('on-coll-change', state)
      }
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div.header-bar
    sider-trigger(:collapsed="collapsed" @on-change="handleCollapsedChange")
    <!--bread-crumb(:list="breadCrumbList")-->
    bread-crumb2
    slot
</template>

<script>
  import SiderTrigger from './SiderTrigger'
  import BreadCrumb2 from './Breadcrumb2/index'
  export default {
    name: 'Navbar',
    components: {
      SiderTrigger,
      BreadCrumb2
    },
    props: {
      collapsed: Boolean
    },
    computed: {
      breadCrumbList () {
        return this.$store.state.app.breadCrumbList
      }
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
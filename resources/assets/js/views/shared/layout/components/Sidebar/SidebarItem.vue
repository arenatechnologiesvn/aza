<template lang="pug">
  el-submenu(:index="`${parentName}`")
    template(slot="title")
      svg-icon(:icon-class="icon(parentItem)")
      span(slot="title" style="margin-left: 10px") {{showTitle(parentItem)}}
    template(v-for="item in children")
      sidebar-item(v-if="showChildren(item)" :key="`menu-${item.name}`" :parent-item="item")
      el-menu-item(v-else :index="`${item.name}`" :route="item")
        svg-icon(:icon-class="`fa-solid circle`" :style="{fontSize: '8px', color: isActive(item.name) ? '#9dd032' : 'white' }")
        span(style="margin-left: 10px") {{showTitle(item)}}
</template>

<script>
  import Mixin from './mixin'
  import MixinItem from './mixin-item'
  export default {
    name: 'SidebarItem',
    mixins: [Mixin, MixinItem],
    methods: {
      isActive (name) {
        return this.$route.name === name;
      }
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div.custom-breadcrumb
    el-breadcrumb(:style="{fontSize: `{fontSize}px`}" :separator="separator")
      el-breadcrumb-item(v-for="item in list" :key="`bread-crumb-${item.name}`" :to="item.path")
        svg-icon(v-if="showIcon" :icon-class="item.meta.icon")
        span {{item.meta.title}}
</template>

<script>
  import './breadcrumb.scss'
  export default {
    name: 'Breadcrumb',
    props: {
      list: {
        type: Array,
        default: () => []
      },
      separator: {
        type: String,
        default: '/'
      },
      fontSize: {
        type: Number,
        default: 14
      },
      showIcon: {
        type: Boolean,
        default: false
      }
    }
  }
</script>

<style scoped>

</style>
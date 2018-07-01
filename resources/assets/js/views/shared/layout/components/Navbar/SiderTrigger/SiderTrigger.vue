<template lang="pug">
  a(@click="handleChange" :class="['sider-trigger-a', collapsed ? 'collapsed' : '']" :style="{fontSize: `${fontSize}px`}")
    span
      svg-icon(:icon-class="icon")
</template>

<script>
  import './sider_trigger.scss'
  export default {
    name: 'SiderTrigger',
    props: {
      collapsed: Boolean,
      icon: {
        type: String,
        default: 'fa-solid bars'
      },
      fontSize: {
        type: Number,
        default: 20
      }
    },
    methods: {
      handleChange () {
        this.$emit('on-change', !this.collapsed)
      }
    }
  }
</script>

<style scoped>

</style>
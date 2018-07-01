<template lang="pug">
  div(:class="['account__container', collapse ? 'collapsed' : '']")
    img(:src="info.avatar")
    div.account__info
      h3.info__role(style="text-transform: uppercase;") {{info.role_name}}
      p.info__description {{info.role_description}}
</template>

<script>
  import './sidebar_account.scss'
  export default {
    name: 'SidebarAccount',
    props: {
      collapse: Boolean,
      info: {
        type: Object,
        default: () => {}
      }
    }
  }
</script>

<style scoped>

</style>
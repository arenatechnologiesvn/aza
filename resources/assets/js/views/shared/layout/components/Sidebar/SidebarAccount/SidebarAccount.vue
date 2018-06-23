<template lang="pug">
  div(:class="['account__container', collapse ? 'collapsed' : '']")
    img(:src="avatar")
    div.account__info
      h3.info__role {{info.role}}
      p.info__description {{info.description}}
</template>

<script>
  import './sidebar_account.scss'
  export default {
    name: 'SidebarAccount',
    props: {
      collapse: Boolean,
      avatar: {
        type: String
      },
      info: Object
    }
  }
</script>

<style scoped>

</style>
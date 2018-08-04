<template lang="pug">
  div(:class="['account__container', collapse ? 'collapsed' : '']")
    img(:src="avatarUrl()")
    div.account__info
      h3.info__role(style="text-transform: uppercase;") {{info.role_name}}
      p.info__description {{info.role_description}}
</template>

<script>
  import './sidebar_account.scss'
  import dummyImage from '~/assets/login_images/dummy-avatar.png'

  export default {
    name: 'SidebarAccount',
    props: {
      collapse: Boolean,
      info: {
        type: Object,
        default: () => {}
      }
    },
    methods: {
      avatarUrl() {
        if (this.info.avatar && this.info.avatar.length) return this.info.avatar[0].url;
        return dummyImage;
      }
    }
  }
</script>

<style scoped>

</style>
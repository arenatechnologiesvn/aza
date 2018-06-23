<template lang="pug">
  div.account-container(v-if="sidebar.opened" style="height: 250px;")
    div.account
      img.account__image(:src="avatar")
      div.account__info
        span.account__name {{ name.toUpperCase() }}
        span.account__description Quản trị viên cao cấp
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    name: 'AccountSidebar',
    computed: {
      ...mapGetters([
          'sidebar',
          'avatar',
          'name'
        ]
      )
    }
  }
</script>
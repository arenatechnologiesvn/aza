<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Cập nhật quyền
      span(style="float: right")
        svg-icon(icon-class="fa-solid ")
    div.card-content
      role-form(:role="currentRole" :is-update="true")
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import RoleForm from './components/Form'

  export default {
    name: 'RoleUpdate',
    components: {
      RoleForm
    },
    computed: {
      ...mapGetters('role', {
        roleById : 'byId'
      }),
      currentRole () {
        return this.roleById(this.$route.params.id);
      }
    },
    methods: {
      ...mapActions('role', {
        'getById': 'getById'
      }),
      getByIdRoute () {
        const id = this.$route.params.id
        this.getById(id)
      },
    },
    watch: {
      $route: 'getByIdRoute'
    },
    created () {
      this.getByIdRoute()
    }
  }
</script>

<style scoped>

</style>
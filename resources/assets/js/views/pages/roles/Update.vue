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
  import { mapActions, mapGetters, mapState} from 'vuex'
  import RoleForm from './components/Form'

  export default {
    name: 'RoleUpdate',
    components: {
      RoleForm
    },
    computed: {
      ...mapGetters('roles', {
        roleById : 'byId'
      }),
      ...mapState([
        'route', // vuex-router-sync
      ]),
      currentRole () {
        console.log(this.roleById(this.$route.params.id))
        return this.roleById(this.$route.params.id);
      }
    },
    methods: {
      ...mapActions('roles', {
        fetchRole: 'fetchSingle'
      }),
      fetchData () {
        this.fetchRole({
          id: this.$route.params.id
        })
      },
    },
    watch: {
      $route: 'fetchData'
    },
    created () {
      this.fetchData()
    }
  }
</script>

<style scoped>

</style>
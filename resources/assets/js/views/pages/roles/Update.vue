<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px; text-transform: uppercase;") CẬP NHẬT QUYỀN {{current && current.title}}
      span(style="float: right")
        svg-icon(icon-class="fa-solid ")
    div.card-content
      role-form(:role="current" :is-update="true")
</template>

<script>
  import { mapActions, mapGetters, mapState} from 'vuex'
  import RoleForm from './components/Form'
  import BaseMixin from '../mixin'
  export default {
    name: 'RoleUpdate',
    mixins: [BaseMixin],
    components: {
      RoleForm
    },
    computed: {
      ...mapGetters('roles', {
        roleById : 'byId',
        isLoading: 'isLoading'
      }),
      ...mapState([
        'route', // vuex-router-sync
      ]),
      current () {
        let role = this.roleById(this.$route.params.id);
        role.is_employee = role.is_employee > 0
        return role
      }
    },
    methods: {
      ...mapActions('roles', {
        fetchRole: 'fetchSingle'
      }),
      fetchData () {
        this.fetchRole({
          id: this.$route.params.id
        }).catch(() => this.$router.push({name: 'roles'}))
      }
    },
    watch: {
      $route: 'fetchData'
    },
    created () {
      this.fetchData()
      this.loading()
    }
  }
</script>
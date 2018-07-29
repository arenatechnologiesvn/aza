<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid user-edit")
        span(style="margin-left: 10px;") CẬP NHẬT NHÂN VIÊN - {{current && current.code}}
      span(style="float: right")
        svg-icon(icon-class="fa-solid ")
    div.card-content
      aza-form(:permission="current" :is-update="true")
</template>

<script>
  import { mapActions, mapGetters, mapState} from 'vuex'
  import AzaForm from './components/Form'
  import BaseMixin from '../mixin'
  export default {
    name: 'EmployeeUpdate',
    mixins: [BaseMixin],
    components: {
      AzaForm
    },
    computed: {
      ...mapGetters('permissions', {
        ById : 'byId',
        isLoading: 'isLoading'
      }),
      ...mapState([
        'route', // vuex-router-sync
      ]),
      current () {
        let permission = this.ById(this.$route.params.id);
        if(permission) {
          permission.is_menu = permission.is_menu > 0
          permission.is_show = permission.is_show > 0
          permission.authorize = permission.authorize > 0
        }
        return permission

      }
    },
    methods: {
      ...mapActions('permissions', {
        fetchUpdate: 'fetchSingle'
      }),
      fetchData () {
        return this.fetchUpdate({
          id: this.$route.params.id
        }).catch(() => this.$router.push({name: 'page404'}))
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
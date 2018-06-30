<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid user-edit")
        span(style="margin-left: 10px;") CẬP NHẬT QUYỀN
      span(style="float: right")
        svg-icon(icon-class="fa-solid ")
    div.card-content
      aza-form(:employee="current" :is-update="true")
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
      ...mapGetters('employees', {
        ById : 'byId',
        isLoading: 'isLoading'
      }),
      ...mapState([
        'route', // vuex-router-sync
      ]),
      current () {
        return this.ById(this.$route.params.id);
      }
    },
    methods: {
      ...mapActions('employees', {
        fetchUpdate: 'fetchSingle'
      }),
      fetchData () {
        this.fetchUpdate({
          id: this.$route.params.id
        })
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
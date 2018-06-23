<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách quyền
    div.control__wraper
      role-control(@on-add="handAddClick")
    div.index__wrapper
      role-table(:roles="roles" @on-update="handUpdateClick" :total="10")
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import RoleTable from './components/Table'
  import RoleControl from './components/Control'
  export default {
    name: 'RoleIndex',
    components: {
      RoleTable,
      RoleControl
    },
    computed: {
      ...mapGetters('role', {
        roles: 'list'
      })
    },
    watch: {
      $route : 'getList'
    },
    methods: {
      ...mapActions('role', {
        'getList': 'getList'
      }),
      handAddClick () {
        this.$router.push({
          name: 'role_create'
        })
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'role_update',
          params: {
            id
          }
        })
      }
    },
    created () {
      this.getList()
    }
  }
</script>

<style scoped>

</style>
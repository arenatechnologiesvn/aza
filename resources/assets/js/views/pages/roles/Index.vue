<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách quyền
    div.control__wraper
      div.form-search
        el-input(placeholder="Tìm kiếm" v-model="search.key" clearable suffix-icon="el-icon-search" style="width: 100%")
      role-control(@on-add="handAddClick" ref="rolControl" :selection="selection")
    div.index__wrapper
      role-table(:roles="currentRoles" :loading="isLoading" @on-update="handUpdateClick" :total="10" @on-selection="onSelected")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import RoleTable from './components/Table'
  import RoleControl from './components/Control'
  export default {
    name: 'RoleIndex',
    components: {
      RoleTable,
      RoleControl
    },
    data () {
      return {
        selection: {},
        search: {
          key: ''
        }
      }
    },
    computed: {
      ...mapGetters('roles', {
        roles: 'list',
        finder: 'finder',
        isLoading: 'isLoading'
      }),
      currentRoles () {
        return this.finder || []
      },
      ...mapState([
        'route'
      ])
    },
    watch: {
      $route : 'fetchData',
      'search.key': 'fetchFind'
    },
    methods: {
      ...mapActions('roles', {
        fetchRoles: 'fetchList',
        fetchSearch: 'search'
      }),
      fetchFind () {
        const searchable = this.roles
          .filter(item =>
            item.title.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1 ||
            item.description.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1
          )
        this.fetchSearch(searchable)
      },
      fetchData() {
        return this.fetchRoles()
      },
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
      },
      onSelected (selection) {
        this.selection = selection
      }
    },
    created () {
      this.fetchData()
    }
  }
</script>

<style scoped>

</style>
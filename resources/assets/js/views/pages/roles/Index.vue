<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH QUYỀN
    div.control__wraper
      div.form-search
        el-input(placeholder="Tìm kiếm" v-model="search.key" clearable suffix-icon="el-icon-search" style="width: 100%")
      role-control(@on-add="handAddClick" ref="rolControl" :selection="selection" @on-delete-selection="onDeleteSelect")
    div.index__wrapper
      role-table(:roles="current" @on-update="handUpdateClick" :total="10" @on-selection="onSelected")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import RoleTable from './components/Table'
  import RoleControl from './components/Control'
  import BaseMixin from '../mixin'

  export default {
    name: 'RoleIndex',
    mixins: [BaseMixin],
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
        isLoading: 'isLoading'
      }),
      current () {
        return this.roles
          .filter(item =>
            item.title.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1 ||
            item.description.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1
          );
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
        fetchSearch: 'search',
        deleteSelection: 'deleteSelection'
      }),
      fetchFind () {
        this.fetchSearch(this.search)
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
      },
      onDeleteSelect (ids) {
        this.confirm(() => {
          this.deleteSelection({
            customUrl: 'deletes',
            data: {data: ids}
          }).then(() => {
            this.$message({
              type: 'success',
              message: `Delete completed`
            })
          })
        }, () => {
          this.$message({
            type: 'info',
            message: `Cancel Delete`
          })
        })
      }
    },
    created () {
      this.loading()
      this.fetchData()
    }
  }
</script>

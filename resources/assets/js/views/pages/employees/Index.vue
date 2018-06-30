<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH NHÂN VIÊN
    div.search__wrapper(style="margin: 10px 0 20px")
      div.form-search__wrapper
        el-form.search
          el-row(style="margin: 0 -10px;")
            el-col(:span="16")
              el-form-item
                el-input(placeholder="Tìm kiếm" v-model="search.key" suffix-icon="el-icon-search" style="width: 100%")
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Vai trò" v-model="search.role_id" )
                  el-option(label="Vai trò 1" value="1")
                  el-option(label="Vai trò 2" value="2")
            el-col(:span="4")
              el-form-item
                el-select(placeholder="Trạng thái" v-model="search.status")
                  el-option(label="Đang hoạt động" value="2")
                  el-option(label="Đang bị khóa" value="3")
    div.control__wraper
      aza-control(@on-add="handAddClick")
    div.index__wrapper
      aza-table(ref="table" :employees="current" :total="total" @on-update="handUpdateClick" @on-change-status="changeStatusHandle")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import AzaSearch from './components/FormSearch'
  import BaseMixin from '../mixin'

  export default {
    name: 'RoleIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl,
      AzaSearch
    },
    computed: {
      ...mapGetters('employees', {
        employees: 'list',
        isLoading: 'isLoading'
      }),
      current () {
        return this.employees
          .filter(item => {
            for(let index in this.search) {
              if (index === 'key') {
                return item.full_name.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1 ||
                  item.name.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1
              } else if(typeof this.search[index] === 'string') {
                  return item[index].toLowerCase().indexOf(this.search[index].toLowerCase()) > -1
              } else {
                return item[index] === this.search[index];
              }
            }
          }
          );
      },
      total () {
        this.current.length
      },
      ...mapState([
        'route'
      ])
    },
    watch: {
      $route : 'fetchData',
      search: {
        handler(){
          this.fetchFind()
        },
        deep: true
      }
    },
    methods: {
      ...mapActions('employees', {
        fetchRoles: 'fetchList',
        fetchSearch: 'search',
        deleteSelection: 'deleteSelection',
        updateRole: 'update'
      }),
      changeStatusHandle (id, data) {
        this.updateRole({
          id: id,
          data: data
        })
      },
      fetchFind () {
        // this.fetchSearch(this.search)
      },
      fetchData() {
        return this.fetchRoles()
      },
      handAddClick () {
        this.$router.push({
          name: 'employee_create'
        })
      },
      handUpdateClick (id) {
        this.$router.push({
          name: 'employee_update',
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
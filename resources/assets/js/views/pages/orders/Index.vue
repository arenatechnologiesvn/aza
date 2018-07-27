<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH ĐƠN HÀNG
    div.search__wrapper(style="margin: 10px 0 20px")
    div.control__wrapper
      aza-control
    div.index__wrapper
      aza-table(ref="table" :orders="current" :total="total")
</template>

<script>
  import { mapGetters, mapActions, mapState } from 'vuex'
  import AzaTable from './components/Table'
  import AzaControl from './components/Control'
  import AzaSearch from './components/FormSearch'
  import BaseMixin from '../mixin'

  export default {
    name: 'EmployeeIndex',
    mixins: [BaseMixin],
    components: {
      AzaTable,
      AzaControl,
      AzaSearch
    },
    computed: {
      ...mapGetters('orders', {
        orders: 'list',
        isLoading: 'isLoading'
      }),
      current () {
        return this.orders
          .filter(item => {
              for(let index in this.search) {
                if (index === 'key') {
                  return item.title.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1 ||
                    item.oder_code.toLowerCase().indexOf(this.search.key.toLowerCase()) > -1
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
      $route : 'fetchData'
    },
    methods: {
      ...mapActions('orders', {
        fetchOrders: 'fetchList'
      }),
      changeStatusHandle (id, data) {
        this.updateRole({
          id: id,
          data: data
        })
      },
      fetchData() {
        return this.fetchOrders()
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
      onChangeRole () {
        this.current.filter(item => item.role_id === this.search.role_id)
      }
    },
    created () {
      this.loading()
      this.fetchData()
    }
  }
</script>
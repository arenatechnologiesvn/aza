<template lang="pug">
  div.form-search__wrapper
    el-form.search
      el-row(style="margin: 0 -10px;")
        el-col(:span="8")
          el-form-item
            el-input(placeholder="Tìm kiếm" v-model="search.key" suffix-icon="el-icon-search" style="width: 100%")
        el-col(:span="12")
          administrative-select(v-model="search.location")
        el-col(:span="4")
          el-form-item
            el-select(placeholder="Khách hàng" v-model="search.customer_id")
              el-option(v-for="item in customerList" :key="item.id" :label="item.name" :value="item.id")
</template>

<script>
  import { mapGetters } from 'vuex'
  import AdministrativeSelect from '~/components/AdministrativeSelect'
  export default {
    name: 'ShopFormSearch',
    components: {
      AdministrativeSelect
    },
    data () {
      return {
        search: {
          key: '',
          location: {},
          customer_id: null
        }
      }
    },
    computed: {
      ...mapGetters('customer', {
        customers: 'list'
      }),
      customerList () {
        return this.customers.map(item => {
          return {
            id: item.id,
            name: item.first_name + ' ' + item.last_name
          }
        })
      }
    }
  }
</script>

<style scoped>

</style>
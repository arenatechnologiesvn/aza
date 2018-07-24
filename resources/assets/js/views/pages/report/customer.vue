<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Tổng doanh thu theo từng khách hàng và sản phẩm
    div
      .control__wrapper
        el-row
          el-col(:span="21")
            el-date-picker(type="date" placeholder="Ngày bắt đầu" v-model="startDate" size="small" style="margin-right: 5px")
            el-date-picker(type="date" placeholder="Ngày kết thúc" v-model="endDate" size="small" style="margin-right: 5px")
            el-select(v-model="selectedCustomer" clearable placeholder="Khách hàng" size="small")
              el-option(v-for="item in customers" :key="item.id" :label="item.name" :value="item.id")
          el-col(:span="3" style="text-align: right")
            el-button(type="success" size="small" @click="")
              svg-icon(icon-class="fa-solid check")
              span.ml-5  Xem
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="icon" label="STT" align="center" width="60")
              el-table-column(prop="name" label="TÊN SẢN PHẨM" sortable min-width="200")
              el-table-column(prop="description" label="SỐ LƯỢNG" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.description || '-' }}
              el-table-column(prop="description" label="ĐỊNH LƯỢNG" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.description || '-' }}
              el-table-column(prop="description" label="KHỐI LƯỢNG" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.description || '-' }}
              el-table-column(prop="description" label="DOANH SỐ " sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.description || '-' }}
          div.pagination__wrapper
            el-pagination(:current-page.sync="currentPage"
              :page-sizes="[10, 20, 30, 50]"
              :page-size="10"
              layout="total, sizes, prev, pager, next"
              :total="tableData.length")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';

export default {
  name: 'customer-report',
  computed: {
    ...mapGetters({
      customers: 'customers/list'
    })
  },
  created() {
    this.fetchCustomers().catch(() => {
      // Do nothing
    });
  },
  data() {
    return {
      tableData: [],
      currentPage: 1,
      startDate: '',
      endDate: '',
      selectedCustomer: ''
    }
  },
  methods: {
    ...mapActions({
      fetchCustomers: 'customers/fetchList'
    })
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

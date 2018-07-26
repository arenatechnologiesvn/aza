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
            el-date-picker(
              v-model="selectedDate"
              type="daterange"
              range-separator="Tới"
              start-placeholder="Ngày bắt đầu"
              end-placeholder="Ngày kết thúc"
              format="dd-MM-yyyy"
              value-format="dd-MM-yyyy"
              style="margin-right: 5px; min-width: 500px"
              size="small"
            )
            el-select(v-model="selectedCustomer" clearable placeholder="Khách hàng" size="small")
              el-option(v-for="item in customers" :key="item.id" :label="item.code + ' - ' + item.user.first_name" :value="item.id")
          el-col(:span="3" style="text-align: right")
            el-button(type="success" size="small" @click="getRevenue" :disabled="!canGetRevenue()")
              svg-icon(icon-class="fa-solid check")
              span.ml-5  Xem
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="num" label="STT" align="center" width="60")
              el-table-column(prop="product_name" label="TÊN SẢN PHẨM" sortable min-width="200")
              el-table-column(prop="quantity_total" label="SỐ LƯỢNG" sortable min-width="120")
              el-table-column(prop="unit" label="ĐỊNH LƯỢNG" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.unit || '-' }}
              el-table-column(prop="mass" label="KHỐI LƯỢNG" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ scope.row.mass || '-' }}
              el-table-column(prop="revenue_total" label="DOANH SỐ  (VND)" sortable min-width="120")
                template(slot-scope="scope")
                  span {{ Number(scope.row.revenue_total).toLocaleString('de-DE') }}
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
      customers: 'customers/list',
      customerRevenue: 'report/customerRevenue'
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
      selectedCustomer: '',
      selectedDate: []
    }
  },
  methods: {
    getRevenue() {
      if (this.canGetRevenue()) {
        this.fetchCustomerRevenue({
          customerId: this.selectedCustomer,
          startDate: this.selectedDate[0],
          endDate: this.selectedDate[1]
        }).catch(() => {
          // Do nothing
        });
      }
    },

    canGetRevenue() {
      return this.selectedCustomer && this.selectedDate.length;
    },

    ...mapActions({
      fetchCustomers: 'customers/fetchList',
      fetchCustomerRevenue: 'report/fetchCustomerRevenue'
    })
  },

  watch: {
    customerRevenue() {
      if (this.customerRevenue) {
        this.tableData = JSON.parse(JSON.stringify(this.customerRevenue));
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

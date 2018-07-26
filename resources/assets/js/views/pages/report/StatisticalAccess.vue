<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Tổng lượng truy cập vào website
    div(style="margin-bottom: 50px")
      access-chart()
    div
      .control__wrapper
        el-row
          el-col(:span="24" style="text-align: center")
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
              el-option(v-for="item in customers" :key="item.id" :label="item.user.last_name + ' ' + item.user.first_name" :value="item.id")
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="num" label="STT" align="center" width="60")
                template(slot-scope="scope")
                  span {{ scope.$index + 1 }}
              el-table-column(prop="access_day" label="NGÀY TRUY CẬP" sortable min-width="200")
              el-table-column(prop="access_count" label="SỐ LẦN" sortable min-width="120")
          div.pagination__wrapper
            el-pagination(:current-page.sync="currentPage"
              :page-sizes="[10, 20, 30, 50]"
              :page-size="10"
              layout="total, sizes, prev, pager, next"
              :total="tableData.length")
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import AccessChart from '~/components/Chart/BarChart'

export default {
  name: 'statistical-access',
  components: {
    AccessChart
  },
  computed: {
    ...mapGetters({
      customers: 'customers/list',
      accessStatistical: 'report/accessStatistical'
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
      selectedDate: [],
      selectedCustomer: '',
      chartOptions: {}
    }
  },
  methods: {
    getStatistical() {
      if (this.canGetStatistical()) {
        this.fetchCustomerAccessStatistical({
          customerId: this.selectedCustomer,
          startDate: this.selectedDate[0],
          endDate: this.selectedDate[1]
        }).catch(() => {
          // Do nothing
        });
      }
    },

    canGetStatistical() {
      return this.selectedCustomer && this.selectedDate.length;
    },

    ...mapActions({
      fetchCustomers: 'customers/fetchList',
      fetchCustomerAccessStatistical: 'report/fetchCustomerAccessStatistical'
    })
  },
  watch: {
    accessStatistical() {
      if (this.accessStatistical) {
        this.tableData = JSON.parse(JSON.stringify(this.accessStatistical));
      }
    },

    selectedCustomer() {
      if (this.canGetStatistical()) this.getStatistical();
    },

    selectedDate() {
      if (this.canGetStatistical()) this.getStatistical();
    }
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

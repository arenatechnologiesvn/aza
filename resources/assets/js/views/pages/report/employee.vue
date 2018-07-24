<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid chart-pie")
        span(style="margin-left: 10px;") Tổng doanh số của nhân viên kinh doanh
    div
      .control__wrapper
        el-row
          el-col(:span="21")
            el-date-picker(type="date" placeholder="Ngày bắt đầu" v-model="startDate" size="small" style="margin-right: 5px")
            el-date-picker(type="date" placeholder="Ngày kết thúc" v-model="endDate" size="small" style="margin-right: 5px")
            el-select(v-model="selectedEmployee" clearable placeholder="Nhân viên" size="small")
              el-option(v-for="item in employees" :key="item.id" :label="item.code + ' - ' + item.user.first_name" :value="item.id")
          el-col(:span="3" style="text-align: right")
            el-button(type="success" size="small" @click="")
              svg-icon(icon-class="fa-solid check")
              span.ml-5  Xem
      div.table__wrapper
        div.index__container
          div.table
            el-table(:data="tableData" border size="small" style="width: 100%")
              el-table-column(prop="num" label="STT" align="center" width="60")
              el-table-column(prop="name" label="TÊN KHÁCH HÀNG" sortable min-width="200")
              el-table-column(prop="revenue" label="TỔNG DOANH SỐ " sortable min-width="200")
                template(slot-scope="scope")
                  span {{ scope.row.revenue || '-' }}
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
  name: 'employee-report',
  computed: {
    ...mapGetters({
      employees: 'employees/list'
    })
  },
  created() {
    this.fetchEmployees().catch(() => {
      // Do nothing
    });
  },
  data() {
    return {
      tableData: [],
      currentPage: 1,
      startDate: '',
      endDate: '',
      selectedEmployee: ''
    }
  },
  methods: {
    ...mapActions({
      fetchEmployees: 'employees/fetchList'
    })
  }
}
</script>

<style lang="scss" scoped>
.control__wrapper {
  margin: 10px 0;
}
</style>

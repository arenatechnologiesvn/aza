<template lang="pug">
  div.index__container
    div.table
      el-table(:data="tableData" border  style="width: 100%")
        el-table-column(type="selection" width="40")
        el-table-column(prop="date" label="HỌ TÊN" sortable)
        el-table-column(prop="name" label="ĐIỆN THOẠI" sortable width="180")
        el-table-column(prop="address" label="EMAIL" sortable)
        el-table-column(prop="username" label="TÀI KHOẢN" sortable)
        el-table-column(prop="role_id" label="VAI TRÒ" sortable)
        el-table-column(prop="status" label="TRẠNG THÁI" sortable)
        el-table-column(prop="tag" label="TÁC VỤ" width="170")
          template(slot-scope="scope")
            router-link.el-button.el-button--warning.el-button--mini(to="/Edit")
              svg-icon(icon-class="fa-solid edit")
              span(style="margin-left: 5px") Sửa
            router-link.el-button.el-button--danger.el-button--mini(to="/delete")
              svg-icon(icon-class="fa-solid trash")
              span(style="margin-left: 5px") Xóa
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage4"
        :page-sizes="[100, 200, 300, 400]"
        :page-size="100"
        layout="total, sizes, prev, pager, next"
        :total="400")
</template>

<script>
  export default {
    name: 'UserTable',
    data() {
      return {
        currentPage4: 1,
        tableData: [{
          date: '2016-05-03',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
          tag: 'Home',
          username: 'laclac',
          role_id: 1,
          status: 0
        }, {
          date: '2016-05-02',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
          tag: 'Office',
          username: 'laclac',
          role_id: 1,
          status: 0
        }, {
          date: '2016-05-04',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
          tag: 'Home',
          username: 'laclac',
          role_id: 1,
          status: 0
        }, {
          date: '2016-05-01',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
          tag: 'Office',
          username: 'laclac',
          role_id: 1,
          status: 0
        }]
      }
    },
    methods: {
      formatter(row, column) {
        return row.address;
      },
      filterTag(value, row) {
        return row.tag === value;
      },
      filterHandler(value, row, column) {
        const property = column['property'];
        return row[property] === value;
      },
      handleSizeChange(val) {
        console.log(`${val} items per page`);
      },
      handleCurrentChange(val) {
        console.log(`current page: ${val}`);
      }
    }
  }
</script>

<style scoped>

</style>
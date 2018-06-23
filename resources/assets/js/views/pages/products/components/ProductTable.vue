<template lang="pug">
  div.index__container
    div.table
      el-table(:data="tableData" border  style="width: 100%")
        el-table-column(type="selection" width="40")
        el-table-column(prop="name" label="TÊN SẢN PHẨM" sortable)
        el-table-column(prop="price" label="GIÁ" sortable width="180")
        el-table-column(prop="unit" label="ĐƠN VỊ" sortable)
        el-table-column(prop="category_id" label="DANH MỤC" sortable)
        el-table-column(prop="company_id" label="NHÀ CUNG CẤP" sortable)
        el-table-column(prop="image" label="HÌNH ẢNH")
          template(slot-scope="scope")
            img(:src="scope.image")
        el-table-column(prop="tag" label="TÁC VỤ" width="100" fixed="right")
          template(slot-scope="scope")
            el-button(type="text" size="small") Edit
            el-button(type="text" size="small") Delete
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
    name: 'ProductTable',
    data() {
      return {
        currentPage4: 1,
        tableData: [{
          name: 'Coca Cola',
          price: '5.000',
          unit: 'Chai',
          category_id: 'Nước uống',
          company_id: 'Coca Cola Cake',
          image: '',
          tag: 0
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
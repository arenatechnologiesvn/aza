<template lang="pug">
  div.account-order
    h4.account-order__title
      svg-icon(icon-class="fa-solid cart-arrow-down")
      template LỊCH SỬ ĐƠN HÀNG
    div.h-line
    div.main-control
      div(style="margin-bottom: 10px;")
        el-input(placeholder="Tìm kiếm đơn hàng" clearable v-model="key" size="small")
          i(slot="prefix" class="el-input__icon el-icon-search")
      div
        el-row(:gutter="10")
          el-col(:span="6")
            el-select(size="small" v-model="status" clearable filterable placeholder="Trạng thái đơn hàng")
              el-option(:value="1" label="Đang xử lý")
              el-option(:value="0" label="Đã hoàn thành")
              el-option(:value="2" label="Đã hủy")
              el-option(:value="-1" label="Tất cả")
          el-col(:span="6")
            el-date-picker(type="date" v-model="apply_at" style="width: 100%" size="small" placeholder="Ngày đặt hàng")
          el-col(:span="6")
            el-date-picker(type="date" v-model="delivery_date" style="width: 100%" size="small" placeholder="Ngày giao hàng")
          el-col(:span="6")
            el-select(v-model="delivery_type" clearable filterable placeholder="Chọn khung giờ" size="small")
              el-option(label="9h - 11h" :value="'9h-11h'")
              el-option(label="11h - 13h" :value="'11h-13h'")
              el-option(label="13h - 15h" :value="'13h-15h'")
              el-option(label="15h - 17h" :value="'15h-17h'")
              el-option(label="17h - 19h" :value="'17h-19h'")
    div.account-order__content(style="padding: 10px;")
      el-table(:data="orders.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" style="width: 100%" border size="small" v-loading="loading")
        el-table-column(type="expand")
          template(slot-scope="props")
            el-table.product(:data="props.row.products" border="border" size="mini")
              el-table-column
                template(slot-scope="product")
                  img.product-img(:src="product.row.img")
              el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="200")
              el-table-column(prop="quantity" label="SL" width="40")
              el-table-column(prop="price" label="GIÁ(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
              el-table-column(prop="total" label="TỔNG(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
              el-table-column(prop="unit" label="ĐƠN VỊ TÍNH" width="100")
        el-table-column(prop="code" label="MÃ ĐƠN HÀNG")
        el-table-column(label="TRẠNG THÁI")
          template(slot-scope="scope")
            el-tag(:type="parseInt(scope.row.status) === 0 ? 'success': parseInt(scope.row.status) === 1 ?  'info' : 'danger'") {{parseInt(scope.row.status) === 0 ? 'Đã hoàn thành' : parseInt(scope.row.status) === 1 ? 'Đang xử lý' : 'Đã bị hủy' }}
        el-table-column(prop="total" label="TỔNG TIỀN(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
        el-table-column(prop="delivery" label="NGÀY GIAO HÀNG" :formatter="(row, column, value) => formatDate(value)" )
        el-table-column(prop="delivery_type" label="GIỜ GIAO HÀNG")
        el-table-column(label="")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Hủy đơn hàng" placement="top")
              el-button(size="mini" type="danger" @click="changeStatus(scope.row.id, 2)" :disabled="scope.row.status === 0 || scope.row.status === 2 " round)
                svg-icon(icon-class="fa-solid ban")
      div.pagination__wrapper(style="padding: 10px 0;")
        el-pagination(@size-change="handleSizeChange"
          @current-change="handleCurrentChange"
            :current-page.sync="currentPage"
            :page-sizes="[10, 20, 40]"
            :page-size="pageSize"
        layout="total, sizes, prev, pager, next"
          :total="orders.length")
</template>

<script>
  import avatar from '~/assets/products/p1.jpg'
  import {mapGetters, mapActions} from 'vuex'
  import {formatNumber} from '~/utils/util'
  import ElSelectDropdown from "element-ui/packages/select/src/select-dropdown";

  export default {
    components: {ElSelectDropdown},
    name: 'AccountOrder',
    computed: {
      ...mapGetters('orders', {
        order: 'list',
        loading: 'isLoading'
      }),
      orders() {
        return this.order.map(item => ({
          id: item.id,
          discount: item.discount,
          code: '#' + item.order_code,
          date: item.apply_at,
          total: item.total_money,
          status: item.status,
          title: item.title,
          delivery: item.delivery,
          delivery_type: item.delivery_type,
          products: item.products.map(p => ({
            id: p.id,
            img: '/' + p.featured[0].directory + '/' + p.featured[0].filename + '.' + p.featured[0].extension,
            quantity: p.pivot.quantity,
            unit: p.unit,
            title: p.name,
            price: p.pivot.real_price,
            total: p.pivot.real_price ? p.pivot.real_price * p.pivot.quantity : 0
          }))
        })).filter(item => item.code.indexOf(this.key) > -1)
          .filter(item => {
            if (this.status === null || this.status === -1 || this.status === '') return true;
            return this.status === item.status
          })
          .filter(item => {
            if (this.delivery_date === null) return true;
            return (+(new Date(item.delivery * 1000)) === +this.delivery_date)
          })
          .filter(item => {
            if (this.apply_at === null) return true;
            return (this.formatDateFromString(this.apply_at) === this.formatDateCompare(item.date))
          })
          .filter(item => {
            console.log(this.delivery_type)
            if (this.delivery_type === null || this.delivery_type === '') return true;
            return (this.delivery_type === item.delivery_type)
          })
      }
    },
    watch: {
      $route: 'fetchData'
    },
    methods: {
      ...mapActions('orders', {
        fetchOrder: 'fetchList',
        updateOrder: 'update'
      }),
      fetchData() {
        this.fetchOrder()
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      formatDateFromString(date) {
        const day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return year + '-' + month + '-' + day
      },
      formatDate(num) {
        let date = new Date(1000 * num)
        const day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return day + '-' + month + '-' + year
      },
      formatDateCompare(num) {
        let date = new Date(1000 * num)
        const day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return year + '-' + month + '-' + day
      },
      handleSizeChange(size) {
        this.pageSize = size
      },
      handleCurrentChange(current) {
        this.currentPage = current
      },
      changeStatus(id, status) {
        if (status === 2) {
          this.$prompt('Hãy nhập lý do hủy', 'Lý do hủy', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            inputPattern: /\w+/,
            inputErrorMessage: 'Bạn phải nhập lý do'
          }).then(value => {
            this.updateOrder({
              id: id,
              data: {
                status: status,
                approve_note: value.value
              }
            }).then(() => {
              this.$message({
                type: 'success',
                message: 'Đơn hàng đã được hủy thành công'
              });
              this.fetchOrder()
            }).catch(() => {
              this.$message({
                type: 'warning',
                message: 'Lỗi khi hủy đơn hàng'
              });
            })
          }).catch(err => {
            this.$message({
              type: 'info',
              message: 'Đơn hàng đã không được hủy'
            });
          });
        }
      }
    },
    data() {
      return {
        currentPage: 1,
        pageSize: 10,
        delivery: 'today',
        status: null,
        delivery_date: null,
        key: '',
        apply_at: null,
        delivery_type: null
      }
    },
    created() {
      this.fetchData()
    }
  }
</script>

<style lang="scss" scoped>
  .main-control {
    padding: 10px;
    text-align: left;
  }

  .account-order {
    background-color: white;
    .h-line {
      display: block;
      margin: 5px 0;
      height: 1px;
      background-color: #eee;
    }
    .product {
      text-align: left;
      word-break: keep-all;
    }
    .product-img {
      height: 70px;
      width: 100%;
      object-fit: cover;
      border-radius: unset;
    }
    .account-order__title {
      margin: 0;
      text-align: left;
      padding: 10px 15px;
      svg {
        margin-right: 10px;
      }
    }
  }
</style>
<template lang="pug">
  div.account-order
    h4.account-order__title
      svg-icon(icon-class="fa-solid address-card")
      template DANH SÁCH ĐƠN HÀNG
    div.h-line
    div.main-control
      div(style="margin-bottom: 10px;")
        el-row(:gutter="5")
          el-col(:span="4")
            el-select(size="small" v-model="status" placeholder="Trạng thái" clearable)
              el-option(:value="1" label="Chờ xác nhận")
              el-option(:value="3" label="Đang xử lý")
              el-option(:value="0" label="Đã hoàn thành")
              el-option(:value="2" label="Đã hủy")
              el-option(:value="-1" label="Tất cả")
          el-col(:span="4")
            el-select(size="small" v-model="customer_id" style="width: 100%;" placeholder="Khách hàng" clearable filterable)
              el-option(v-for="item in customerList" :key="item.id" :label="item.value" :value="item.id")
              el-option(:value="-1" label="Tất cả")
          el-col(:span="16")
            el-input(placeholder="Tìm kiếm đơn hàng" v-model="key" size="small")
              i(slot="prefix" class="el-input__icon el-icon-search")
      div
        el-row(:gutter="5")
          el-col(:span="6")
            el-dropdown(split-button type="primary" @command="handleBulkSelection" size="small" style="margin-right: 5px")
              span Tác vụ
              el-dropdown-menu(slot="dropdown")
                el-dropdown-item(v-if="status === 1" command="PROCESS")
                  svg-icon(icon-class="fa-solid check-circle")
                  span Xác nhận đơn hàng
                el-dropdown-item(v-if="status === 3" command="COMPLETE")
                  svg-icon(icon-class="fa-solid check-circle")
                  span Hoàn thành đơn hàng
                el-dropdown-item(v-if="status === 1 || status === 3" command="CANCEL" style="color: red")
                  svg-icon(icon-class="fa-solid ban")
                  span Hủy đơn hàng
            el-button(type="success" size="small" @click="exportExcelFile" :disabled="status === -1")
              svg-icon(icon-class="fa-solid file-excel")
              span.ml-5  Xuất Excel
          el-col(:span="6" style="text-align: right")
            el-radio-group(size="small" v-model="delivery_range")
              el-radio-button(label="1") Hôm nay
              el-radio-button(label="7") Tuần qua
              el-radio-button(label="-1") Tất cả
          el-col(:span="4")
            el-date-picker(type="date" style="width: 100%" v-model="apply_at" size="small" placeholder="Ngày đặt hàng")
          el-col(:span="4")
            el-date-picker(type="date" style="width: 100%" v-model="delivery_date" size="small" placeholder="Ngày giao hàng")
          el-col(:span="4")
            el-select(v-model="delivery_type" clearable filterable placeholder="Chọn khung giờ" size="small")
              el-option(:label="item" :value="item" v-for="item in times" :key="item")
    div.account-order__content(style="padding: 10px;")
      order-detail(ref="showDetail")
      el-table(:data="orders.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" @selection-change="handleSelectionChange" style="width: 100%" border size="small" v-loading="loading")
        el-table-column(type="selection" width="40")
        el-table-column(type="expand")
          template(slot-scope="props")
            el-table.product(:data="props.row.products" border="border" size="mini")
              el-table-column
                template(slot-scope="product")
                  img.product-img(:src="product.row.img")
              el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="200")
              el-table-column(prop="quantity" label="SL" width="40")
              el-table-column(prop="price" label="GIÁ (VNĐ)" :formatter="(row, column, value) => currencyFormat(value)")
              el-table-column(prop="total" label="TỔNG (VNĐ)" :formatter="(row, column, value) => currencyFormat(value)")
              el-table-column(prop="unit" label="Đơn vị tính" width="100")
        el-table-column(prop="code" label="MÃ ĐƠN HÀNG" sortable min-width="150")
        el-table-column(prop="customer.code" label="MÃ KH" sortable min-width="100")
        el-table-column(prop="customer.user.full_name" label="TÊN KH" sortable min-width="200")
        el-table-column(label="TRẠNG THÁI" min-width="150" align="center")
          template(slot-scope="scope")
            el-tag(:type="showingOrderStatus[scope.row.status].type") {{ showingOrderStatus[scope.row.status].status }}
        el-table-column(prop="total" label="TỔNG TIỀN (VNĐ)" :formatter="(row, column, value) => currencyFormat(value)" min-width="150" align="right")
        el-table-column(prop="date" label="NGÀY ĐẶT HÀNG" :formatter="(row, column, value) => formatDate(value)" min-width="150" align="center")
        el-table-column(prop="delivery" label="NGÀY GIAO HÀNG" :formatter="(row, column, value) => formatDate(value)" min-width="150" align="center")
        el-table-column(prop="delivery_type" label="GIỜ GIAO HÀNG" min-width="150" align="center")
        el-table-column(prop="id" label="TÁC VỤ" width="200" fixed="right")
          template(slot-scope="scope")
            el-tooltip(v-if="![0, 2].includes(parseInt(scope.row.status))" effect="dark" :content="parseInt(scope.row.status) === 1 ? 'Xác nhận đơn hàng' : 'Hoàn thành đơn hàng'" placement="top")
              el-button(size="mini" @click="changeStatus(scope.row.id, scope.row.status, 3)" :disabled="parseInt(scope.row.status) === 0 || parseInt(scope.row.status) === 2" round)
                svg-icon(icon-class="fa-solid check-circle")
            el-tooltip(v-if="![0, 2].includes(parseInt(scope.row.status))" effect="dark" content="Hủy đơn hàng" placement="top")
              el-button(size="mini" type="danger" @click="changeStatus(scope.row.id, scope.row.status, 2)" :disabled="parseInt(scope.row.status) === 0 || parseInt(scope.row.status) === 2 " round)
                svg-icon(icon-class="fa-solid ban")
            el-tooltip(effect="dark" content="Xem chi tiết" placement="top")
              el-button(size="mini" type="primary" @click="onView(scope.row.id)" round)
                svg-icon(icon-class="fa-solid eye")
      div.pagination__wrapper(style="padding: 10px 0;")
        el-pagination(@size-change="handleSizeChange"
          @current-change="handleCurrentChange"
            :current-page.sync="currentPage"
            :page-sizes="[10, 20, 30, 50]"
            :page-size="pageSize"
        layout="total, sizes, prev, pager, next"
          :total="orders.length")
</template>

<script>
  import { mapGetters, mapActions} from 'vuex'
  import { currencyFormat } from '~/utils/util'
  import OrderDetail from '../../pages/client/components/OrderDetail/index'
  import excelExport from '~/utils/excel/export2Excel.js'
  import dummyImage from '~/assets/login_images/dummy-image.jpg'
  import moment from 'moment'
  import { get } from '~/api/setting'

  const COMPLETE_STATUS = 0;
  const CONFIRM_STATUS = 1;
  const CANCEL_STATUS = 2;
  const PROCESSING_STATUS = 3;
  const LABEL_ORDER_STATUS = [
    { status: 'Đã hoàn thành', type: 'success' },
    { status: 'Chờ xác nhận', type: 'warning' },
    { status: 'Đã hủy', type: 'danger' },
    { status: 'Đang xử lý', type: 'info' }
  ]

  export default {
    components: {OrderDetail},
    name: 'AccountOrder',
    computed: {
      ...mapGetters('orders', {
        order: 'list',
        loading: 'isLoading'
      }),
      ...mapGetters('customers', {
        customers: 'list'
      }),
      customerList () {
        return this.customers.map(item => {
          return {
            id: item.id,
            value: item.user.full_name
          }
        })
      },
      orders () {
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
          customer: item.customer,
          products: item.products.map(p => {
            return {
              id: p.id,
              img: p.featured && p.featured.length ? p.featured[0].url : dummyImage,
              quantity: p.pivot.quantity,
              unit: p.unit,
              title: p.name,
              price: p.pivot.real_price,
              total: p.pivot.real_price ? p.pivot.real_price * p.pivot.quantity : 0
            };
          })
        })).sort((a, b) => +b.date - +a.date)
          .filter(item => item.code.indexOf(this.key) > -1)
          .filter(item => {
            if(this.status === null || this.status === -1 || this.status === '') return true;
            return parseInt(this.status) === parseInt(item.status)
          })
          .filter(item => {
            if(this.delivery_date === null) return true;
            return (+(new Date(item.delivery * 1000)) === +this.delivery_date)
          })
          .filter(item => {
            if(this.apply_at === null) return true;
            return (this.formatDateFromString(this.apply_at) === this.formatDateCompare(item.date))
          })
          .filter(item => {
            if(this.delivery_type === null || this.delivery_type === '' ) return true;
            return (this.delivery_type.toString().trim()=== item.delivery_type.toString().trim())
          })
          .filter(item => {
            if(this.customer_id === null || this.customer_id === '' || this.customer_id === -1) return true;
            return (this.customer_id.toString().trim() === item.customer.id.toString().trim())
          })
          .filter(item => {
            if(this.delivery_range === null || parseInt(this.delivery_range) === -1 ) return true;
            else {
              const nDate = new Date
              const end = +(nDate)
              const before = end - (parseInt(this.delivery_range) * 3600 * nDate.getHours() * 1000);
              const d = +(new Date(item.date * 1000))
              return d >= before && d <= end
            }
            // return (this.customer_id.toString().trim() === item.customer.id.toString().trim())
          })
      },
      times () {
        return this.timeFrame  && this.timeFrame.length && this.timeFrame.map(item => item.start + ' - ' + item.end)
      }
    },
    watch: {
      $route : 'fetchData'
    },
    methods: {
      ...mapActions('orders', {
        fetchOrder: 'fetchList',
        updateOrder: 'update',
        bulkUpdate: 'bulkUpdate'
      }),
      ...mapActions('customers', {
        fetchCustomers: 'fetchList',
      }),
      onView (id) {
        this.$refs['showDetail'].detail(id)
      },
      canExecute(message) {
        return new Promise(resolve => this.$confirm(message, 'Xác nhận', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          resolve(true);
        }).catch(() => {
          // Do nothing
        }));
      },
      fetchData () {
        this.fetchOrder()
      },
      changeStatus(id, currentStatus, targetStatus) {
        if (currentStatus === CONFIRM_STATUS && targetStatus === PROCESSING_STATUS) {
          this.canExecute('Bạn muốn xác nhận đơn hàng này').then(() => {
            this.updateOrder({ id, data: { status: targetStatus } }).then(() => {
              this.successNotify('Xác nhận đơn hàng thành công');
            }).catch(() => {
              this.failedNotify('Xác nhận đơn hàng thất bại');
            })
          })
        } else if (currentStatus === PROCESSING_STATUS && targetStatus === COMPLETE_STATUS) {
          this.canExecute('Bạn muốn hoàn thành đơn hàng này').then(() => {
            this.updateOrder({ id, data: { status: targetStatus } }).then(() => {
              this.successNotify('Duyệt hoàn thành đơn hàng thành công');
            }).catch(() => {
              this.failedNotify('Duyệt hoàn thành đơn hàng thất bại');
            })
          })
        } else if ([CONFIRM_STATUS, PROCESSING_STATUS].includes(currentStatus) && targetStatus === CANCEL_STATUS) {
          this.openCancelReasonModal().then(reason => {
            this.updateOrder({ id, data: { status: targetStatus, approve_note: reason }}).then(() => {
              this.successNotify('Hủy đơn hàng thành công');
            }).catch(() => {
              this.failedNotify('Hủy đơn hàng thất bại');
            })
          });
        }
      },
      openCancelReasonModal() {
        return new Promise((resolve) => {
          this.$prompt('Hãy nhập lý do hủy', 'Lý do hủy', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            inputPattern: /\w+/,
            inputErrorMessage: 'Bạn phải nhập lý do'
          }).then(reasonInput => {
            resolve(reasonInput.value);
          }).catch(() => {
            // Do nothing
          });
        });
      },
      currencyFormat(value) {
        return currencyFormat(value)
      },
      formatDateFromString (date) {
        const day = date.getDate() < 10 ? '0'+  date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0'+ (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return year + '-' + month + '-' + day
      },
      formatDate(num) {
        let date = new Date(1000*num)
        const day = date.getDate() < 10 ? '0'+  date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0'+ (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return day + '-' + month + '-' +year
      },
      formatDateCompare (num) {
        let date = new Date(1000*num)
        const day = date.getDate() < 10 ? '0'+  date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0'+ (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return year + '-' + month + '-' + day
      },
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
      },
      handleSelectionChange(selection) {
        this.orderSelectedIds = selection.map((item) => {
          return item.id;
        });
      },
      handleBulkSelection(command) {
        if (command === 'PROCESS') {
          this.canExecute('Bạn muốn xác nhận những đơn hàng này').then(() => {
            this.bulkUpdate({ ids: this.orderSelectedIds, data: { status: PROCESSING_STATUS } }).then(() => {
              this.fetchData();
              this.successNotify('Xác nhận đơn hàng thành công');
            }).catch(() => {
              this.failedNotify('Xác nhận đơn hàng thất bại');
            })
          });
        } else if (command === 'COMPLETE') {
          this.canExecute('Bạn muốn hoàn thành những đơn hàng này').then(() => {
            this.bulkUpdate({ ids: this.orderSelectedIds, data: { status: COMPLETE_STATUS } }).then(() => {
              this.fetchData();
              this.successNotify('Hoàn thành đơn hàng thành công');
            }).catch(() => {
              this.failedNotify('Hoàn thành đơn hàng thất bại');
            })
          });
        } else if (command === 'CANCEL') {
          this.openCancelReasonModal().then(reason => {
            this.bulkUpdate({ ids: this.orderSelectedIds, data: { status: COMPLETE_STATUS, approve_note: reason } }).then(() => {
              this.fetchData();
              this.successNotify('Hủy đơn hàng thành công');
            }).catch(() => {
              this.failedNotify('Hủy đơn hàng thất bại');
            })
          });
        }
      },
      successNotify(message) {
        this.$notify({
          title: 'Thông báo',
          message: message,
          type: 'success'
        })
      },
      failedNotify(message) {
        this.$notify({
          title: 'Thông báo',
          message: message,
          type: 'error'
        })
      },
      exportExcelFile() {
        const exportData = this.orders.map((item, index) => {
          return {
            "STT": index + 1,
            "MÃ ĐƠN HÀNG": item.code.indexOf('#') > -1 ? item.code.replace('#', '') : item.code,
            "MÃ KH": item.customer.code,
            "TÊN KH": item.customer.user.full_name,
            "TỔNG TIỀN (VNĐ)": currencyFormat(item.total),
            "NGÀY ĐẶT HÀNG": this.formatDate(item.date),
            "NGÀY GIAO HÀNG": this.formatDate(item.delivery),
            "GIỜ GIAO HÀNG": item.delivery_type
          };
        });
        excelExport(`DSDH_${moment().format('DDMMYYYY_hhmmss')}`, exportData).then(() => {
          // Do nothing
        }).catch(() => {
          // Do nothing
        });
      }
    },
    data () {
      return {
        currentPage: 1,
        pageSize: 10,
        delivery: 'today',
        status: 1,
        delivery_date: null,
        key: '',
        delivery_type: null,
        apply_at: null,
        customer_id: null,
        delivery_range: null,
        showingOrderStatus: LABEL_ORDER_STATUS,
        orderSelectedIds: [],
        timeFrame: []
      }
    },
    created () {
      this.fetchData()
      this.fetchCustomers()
      get('timeFrame').then(res => {
        (res.data) && (this.timeFrame = res.data.value)
      }).catch(() => {
        this.timeFrame = []
      })
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
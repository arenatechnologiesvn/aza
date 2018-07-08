<template lang="pug">
  div.account-order
    h4.account-order__title
      svg-icon(icon-class="fa-solid cart-arrow-down")
      template LỊCH SỬ ĐƠN HÀNG
    div.h-line
    div.account-order__content
      el-table(:data="tableData" style="width: 100%" border size="small")
        el-table-column(type="expand")
          template(slot-scope="props")
            el-table.product(:data="props.row.products" border="border" size="mini")
              el-table-column
                template(slot-scope="product")
                  img.product-img(:src="product.row.img")
              el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="300")
              el-table-column(prop="quantity" label="SL" width="40")
              el-table-column(prop="price" label="GIÁ" width="70")
              el-table-column(label="TT" width="100")
                template(slot-scope="scope")
                  el-tag(:type="scope.row.status === 1 ? 'success': 'danger'") {{scope.row.status === 1 ? 'Đã nhận': 'Đang chờ'}}
              el-table-column(prop="total" label="TỔNG" width="70")
              el-table-column(prop="receive" label="NGÀY NHẬN" width="100")
        el-table-column(prop="code" label="MÃ ĐƠN HÀNG" width="170")
        el-table-column(prop="count" label="SỐ LƯỢNG" width="100")
        el-table-column(label="TRẠNG THÁI" width="130")
          template(slot-scope="scope")
            el-tag(:type="scope.row.status === 1 ? 'success': 'danger'") {{scope.row.status === 1 ? 'Đã hoàn thành': 'Đang xử lý'}}
        el-table-column(prop="total" label="TỔNG TIỀN" width="120")
        el-table-column(prop="date" label="NGÀY ĐẶT HÀNG")
        el-table-column(width="120")
          template(slot-scope="scope")
            el-button(size="mini" type="primary")
              svg-icon(icon-class="fa-solid eye")
</template>

<script>
  import avatar from '~/assets/products/p1.jpg'
  import avatar2 from '~/assets/products/p2.jpg'
  import avatar3 from '~/assets/products/p3.jpg'
  export default {
    name: 'AccountOrder',
    data () {
      return {
        tableData: [
          {
            code: '#20278900-78990-99',
            date: '29/05/2018',
            count: 5,
            total: 800000,
            status: 0,
            products: [
              {
                id: 1,
                img: avatar,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000,
                status: 1
              },
              {
                id: 2,
                img: avatar2,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              },
              {
                id: 3,
                img: avatar3,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              }
            ]
          },
          {
            code: '#20278900-78990-99',
            date: '29/05/2018',
            count: 5,
            total: 800000,
            status: 1,
            products: [
              {
                id: 1,
                img: avatar3,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000,
                status: 1
              },
              {
                id: 2,
                img: avatar,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              },
              {
                id: 3,
                img: avatar3,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              }
            ]
          },
          {
            code: '#20278900-78990-99',
            date: '29/05/2018',
            count: 5,
            total: 800000,
            status: 1,
            products: [
              {
                id: 1,
                img: avatar2,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000,
                status: 1
              },
              {
                id: 2,
                img: avatar3,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              },
              {
                id: 3,
                img: avatar,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              }
            ]
          },
          {
            code: '#20278900-78990-99',
            date: '29/05/2018',
            count: 5,
            total: 800000,
            status: 0,
            products: [
              {
                id: 1,
                img: avatar,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000,
                status: 1
              },
              {
                id: 2,
                img: avatar3,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              },
              {
                id: 3,
                img: avatar,
                quantity: 10,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                receive: '03/06/2018',
                price: 35000,
                total: 350000
              }
            ]
          }
        ]
      }
    }
  }
</script>

<style lang="scss" scoped>
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
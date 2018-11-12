<template lang="pug">
  el-dialog.detail(title="XÁC NHẬN ĐƠN HÀNG" width="60%" :visible.sync="show" style="text-align: left;")
    el-row.content-order(:gutter="20" v-if="order")
      el-col.body-item(:span="12")
        strong CHỦ CỬA HÀNG:
        span {{ user.full_name }}
      el-col.body-item(:span="12")
        strong SĐT:
        span {{ user.phone }}
      el-col.body-item(:span="12")
        strong TÊN CỬA HÀNG:
        span {{ selectedShop ? selectedShop.name : '' }}
      el-col.body-item(:span="12")
        strong SĐT CỬA HÀNG:
        span {{ selectedShop ? selectedShop.phone : '' }}
      el-col.body-item(:span="24")
        strong ĐỊA CHỈ NHẬN HÀNG:
        span {{order.delivery_address}}
      el-col.body-item(:span="24")
        strong NGÀY ĐẶT HÀNG:
        span {{ applyDate() }}
      el-col.body-item(:span="12")
        strong NGÀY GIAO HÀNG:
        span {{ deliveryDate() }}
      el-col.body-item(:span="12")
        strong GIỜ GIAO HÀNG:
        span {{order.delivery_type}}
      el-col.body-item(:span="24" v-show="order.description && order.description.length > 0")
        strong SẢN PHẨM NGOÀI DANH MỤC:
        span {{order.description}}
      el-col.body-item(:span="24" v-show="order.title && order.title.length > 0")
        strong GHI CHÚ VÀ NHẬN XÉT:
        span {{order.title}}
    div.content
      h5.table-title(style="text-align: left;")
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH SẢN PHẨM
      el-table(:data="orderableProducts" border="border" size="mini" v-loading="isSaving")
        el-table-column(width="70")
          template(slot-scope="product")
            img.product-img(:src="product.row.img")
        el-table-column(prop="title" label="TÊN SẢN PHẨM" min-width="200")
        el-table-column(prop="unit" label="ĐƠN VỊ TÍNH" min-width="100")
        el-table-column(prop="quantity" label="SL" width="40")
        el-table-column(prop="price" label="GIÁ (₫)" :formatter="(row, column, value) => currencyFormat(value)" min-width="100")
        el-table-column(prop="total" label="TỔNG (₫)" min-width="100")
          template(slot-scope="product")
            span {{ currencyFormat(productTotal(product.row)) }}
    div.total(style="margin-top: 5px")
      div.item
        strong TỔNG TIỀN ({{ orderableProducts ? orderableProducts.length : 0 }} sản phẩm):
        span {{ currencyFormat(order.total_money) }} ₫
    div.footer(style="text-align: right")
      el-button-group
        el-button(type="success" size="small" :disabled="isSaving" style="width: 100%")
          svg-icon(icon-class="fa-solid paper-plane")
          span(@click="orderCart") Đặt hàng
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { currencyFormat } from "~/utils/util";
import moment from 'moment';

export default {
  name: "OrderConfirmDialog",
  data() {
    return {
      show: false
    };
  },
  props: {
    order: {
      type: Object,
      default: () => {}
    },
    user: {
      type: Object,
      default: () => {}
    },
    shops: {
      type: Array,
      default: () => []
    },
    products: {
      type: Array,
      default: () => []
    }
  },
  computed: {
    ...mapGetters('orders', {
      isSaving: 'isLoading'
    }),
    orderableProducts() {
      return this.products.filter((item) => {
        return parseInt(item.quantity) > 0;
      })
    },
    selectedShop() {
      if (!this.order || !this.order.shop_id) return null;
      return this.shops.find(item => {
        return parseInt(item.id) === parseInt(this.order.shop_id);
      });
    }
  },
  methods: {
    showConfirmDialog() {
      this.show = true;
    },
    closeConfirmDialog() {
      this.show = false;
    },
    orderCart() {
      this.$emit("on-order-cart");
    },
    currencyFormat(value) {
      return currencyFormat(value);
    },
    deliveryDate() {
      if (!this.order || !this.order.delivery) return '';
      return moment(this.order.delivery).format('DD-MM-YYYY');
    },
    applyDate() {
      return moment().format('DD-MM-YYYY');
    },
    productTotal(product) {
      return product.real_price && product.quantity ? product.real_price * product.quantity : 0
    }
  }
};
</script>

<style lang="scss" scoped>
.product-img {
  height: 50px;
  width: 50px;
  object-fit: cover;
}
h4 {
  text-transform: uppercase;
  text-align: center;
  font-weight: bolder;
}
strong {
  margin-right: 10px;
}
.table-title {
  border-top: 1px solid #eeeeee;
  padding-top: 10px;
}
.detail {
  .el-col {
    padding: 5px 10px;
  }
}
.body-title {
  margin-top: 0;
  margin-bottom: 10px;
}
.body-item {
  font-size: 0.8em;
}
.footer {
  margin-top: 20px;
  padding-top: 10px;
  text-align: right;
  border-top: 1px solid #eeeeee;
  svg {
    margin-right: 10px;
  }
}
.content-order {
  position: relative;
}
.total {
  text-align: right;
  .item {
    padding: 10px 0;
  }
}
</style>
<style lang="scss">
.el-dialog__header {
  background-color: #2d3a4b;
  color: white;
  font-weight: bolder;
  span {
    color: white;
    font-weight: bolder;
    text-transform: uppercase;
  }
}
.el-dialog__body {
  padding: 15px;
}
</style>

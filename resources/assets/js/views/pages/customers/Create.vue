<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid user-plus")
        span(style="margin-left: 10px;") THÊM MỚI KHÁCH HÀNG
      span(style="float: right")
        svg-icon(icon-class="fa-solid arrow-alt-left")
    div.card-content
      customer-form
</template>

<script>
  import CustomerForm from './components/Form'
  export default {
    name: 'CreateCustomer',
    components: {
      CustomerForm
    }
  }
</script>

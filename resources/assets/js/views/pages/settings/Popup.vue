<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid desktop")
        span Nội dung
      div
        el-form(v-model="popup")
          el-form-item(label="Tiêu đề popup")
            el-input(v-model="popup.title" placeholder="Chương trình khuyến mãi ngày hè")
          el-form-item(label="Nội dung khuyến mãi")
            el-input(v-model="popup.content" type="textarea" rows="5" placeholder="Khuyến mãi các mặt hàng")
          el-form-item(label="Giá trị khuyến mãi")
            el-input(v-model="popup.discount" type="number" placeholder="40")
          el-form-item(label="Đường dẫn đến sản phẩm")
            el-input(v-model="popup.link" placeholder="http://localhost:8000/#/")
          el-form-item(style="text-align: right;")
            el-button(type="primary") Lưu
            el-button(type="default") Xem trước
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid cogs")
        span Cấu hình
      div
        el-form(v-model="settings")
          el-form-item(label="Chọn Font chữ")
            el-select(v-model="settings.font" placeholder="Times New Roman")
              el-option(v-for="font in fonts" :label="font" :value="font" :key="font")
          el-form-item(label="Chọn Size chữ")
            el-select(v-model="settings.size" placeholder="13")
              el-option(v-for="size in sizes" :label="size" :value="size" :key="size")
          el-form-item
            el-button(type="primary") Lưu
</template>

<script>

  export default {
    name: '',
    computed: {
      fonts () {
        return [
          'Time News Roman',
          'Roboto'
        ]
      },
      sizes () {
        return [
          1,
          3,
          7,
          8,
          10
        ]
      }
    },
    data () {
      return {
        popup: {
          title: '',
          content: '',
          discount: '',
          link: ''
        },
        settings: {
          font: 'Times New Roman',
          size: 12
        }
      }
    }
  }
</script>

<style scoped>
  svg {
    margin-right: 10px;
  }
</style>
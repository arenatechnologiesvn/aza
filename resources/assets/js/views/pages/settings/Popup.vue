<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid desktop")
        span Cài đặt popup
      div
        popup(:popup="popup" ref="myPopup")
        el-form(v-model="popup")
          el-form-item(label="Bật/tắt Popup")
            el-switch(v-model="popup.show")
          el-form-item(label="Tiêu đề popup")
            el-input(v-model="popup.title" placeholder="Chương trình khuyến mãi ngày hè")
          el-form-item(label="Nội dung khuyến mãi")
            el-input(v-model="popup.content" type="textarea" rows="5" placeholder="Khuyến mãi các mặt hàng")
          el-form-item(label="Giá trị khuyến mãi")
            el-input(v-model="popup.discount" type="number" placeholder="40")
          el-form-item(label="Đường dẫn đến sản phẩm")
            el-input(v-model="popup.url" placeholder="http://localhost:8000/#/")
          el-form-item(label="Chọn Font chữ")
            el-select(v-model="popup.font" placeholder="Times New Roman" style="width: 100%")
              el-option(v-for="font in fonts" :label="font" :value="font" :key="font")
          el-form-item(label="Chọn Size chữ")
            el-select(v-model="popup.size" placeholder="13" style="width: 100%")
              el-option(v-for="size in sizes" :label="size" :value="size" :key="size")
          el-form-item(style="text-align: right;")
            el-button(type="primary" @click="savePopup") Lưu thông tin
            el-button(type="default" @click="showPopup") Xem trước
</template>

<script>
  import { get, update } from '~/api/setting'
  import Popup from '~/views/shared/layout/client/components/Popup'
  export default {
    name: '',
    components: {
      Popup
    },
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
          show: false,
          title: '',
          content: '',
          discount: '',
          url: '',
          font: 'Times New Roman',
          size: 12
        }
      }
    },
    methods: {
      savePopup () {
        update('popup', {popup: this.popup}).then(res=> this.popup = res.data.value )
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      },
      showPopup () {
        this.$refs['myPopup'].fShow()
      }
    },
    created () {
      get('popup').then(res => this.popup = res.data.value)
    }
  }
</script>

<style scoped>
  svg {
    margin-right: 10px;
  }
</style>
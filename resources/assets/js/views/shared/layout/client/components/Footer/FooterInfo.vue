<template lang="pug">
  div.footer-info__container
    el-row(type="flex")
      el-col(:span="6" v-for="item in infos" :key="item.title")
        info-item(:title="item.title")
          template(slot="footer-content")
            ul.footer-info__content
              li(v-for="li_item in item.contents" :key="li_item.label")
                strong {{li_item.label}}
                span(v-if="li_item.content && li_item.content.length > 0") {{li_item.content}}
</template>

<script>
  import InfoItem from './InfoItem'
  export default {
    name: 'FooterInfo',
    props : {
      infos: {
        type: Array,
        default: () => [
          {
            title: 'LIÊN HỆ',
            contents: [
              {
                label: 'ĐC:',
                content: '686/22/11/ Nguyễn Đình Chiểu, Phường 11, QUận 3, TPHCM'
              },
              {
                label: 'DT:',
                content: '0987.346.126 - 0988.347.128'
              },
              {
                label: 'Email:',
                content: 'info@azavn.com'
              }
            ]
          },
          {
            title: 'VỀ AZA',
            contents: [
              {
                label: 'Chính sách mua hàng',
                content: ''
              },
              {
                label: 'Chính sách bảo mật',
                content: ''
              },
              {
                label: 'Điều khoản sử dụng',
                content: ''
              },
              {
                label: 'Thông tin tuyển dụng',
                content: ''
              }
            ]
          },
          {
            title: 'SẢN PHẨM',
            contents: [
              {
                label: 'Thực phẩm sạch',
                content: ''
              },
              {
                label: 'Đồ uống',
                content: ''
              },
              {
                label: 'Trái cây',
                content: ''
              },
              {
                label: 'Thực phẩm tươi sống',
                content: ''
              }
            ]
          },
          {
            title: 'TẢI ỨNG DỤNG',
            contents: [
              {
                label: 'ANDROID',
                content: ''
              },
              {
                label: 'IOS',
                content: ''
              }
            ]
          }
        ]
      }
    },
    components: {
      InfoItem
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div.footer-info__container
    el-row(:gutter="20")
      el-col(:md="6" :sm="12" :xs="12" :lg="6" :xl="6" v-if="company")
        info-item(title="Liên hệ")
          template(slot="footer-content")
            ul.footer-info__content
              li
                strong ĐC:
                span {{company.address}}
              li
                strong ĐT:
                span {{company.phone}}
              li
                strong Email:
                span {{company.email}}
      el-col(:md="6" :sm="12" :xs="12" :lg="6" :xl="6" v-for="item in infos" :key="item.title")
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
    computed: {
      company () {
        return this.$store.getters.settings.company
      }
    },
    components: {
      InfoItem
    }
  }
</script>

<style scoped>

</style>
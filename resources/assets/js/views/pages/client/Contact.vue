<template lang="pug">
  div.container
    bread-crumb
    div.grid-content(style="background-color: white; box-show: -1px 1px 1px 2px rgba(0,0,0,0.1); padding: 10px 15px; margin: 10px 0;")
      el-row(style="min-height: 400px;" :gutter="50")
        el-col(:xs="12" :sm="12" :md="10" style="height: 300px")
          iframe(src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2sus!4v1390839289319"
          width="100%" height="400" style="border:0" allowfullscreen)
        el-col(:xs="12" :sm="12" :md="14")
          el-form(ref="form" v-model="contact" size="small")
            el-form-item(label="Họ tên")
              el-input(v-model="contact.name" placeholder="Họ tên" size="small")
            el-form-item(label="Email")
              el-input(type="email" v-model="contact.email" placeholder="Địa chỉ Email" size="small")
            el-form-item(label="Điện thoại")
              el-input(type="phone" v-model="contact.phone" placeholder="Điện thoại" size="small")
            el-form-item(label="Nội dung")
              el-input(type="textarea" rows="5" v-model="contact.content" placeholder="Nội dung yêu cầu..." size="small")
            el-form-item
              el-button(type="success") Gửi yêu cầu
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  export default {
    name: "contact",
    components: {
      BreadCrumb
    },
    props: {
      contact: {
        type: Object,
        default: () => ({
          name: '',
          email: '',
          phone: '',
          content: ''
        })
      }
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div(style="background-color: white;")
    el-card
      span(slot="header")
        svg-icon(icon-class="fa-solid home")
        span Giới thiệu công ty
      div
        el-form(v-model="introduce")
          div
            vue-editor(v-model="introduce.content")
    div(style="padding: 20px;")
      el-button(type="primary" @click="save") Lưu thông tin

</template>

<script>
  import { VueEditor } from "vue2-editor"
  import { get, update } from '~/api/setting'
  export default {
    name: "home",
    components: {
      VueEditor
    },
    data () {
      return {
        introduce: {
          content: ''
        }
      }
    },
    methods: {
      save () {
        update('introduce', {introduce: this.introduce})
          .then(res=> this.introduce = res.data.value )
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      }
    },
    created () {
      get('introduce').then(res => {
        (res.data) && (this.introduce = res.data.value)
      } )
    }
  }
</script>

<style lang="scss" scoped>
  svg {
    margin-right: 10px;
  }
</style>
<template lang="pug">
  el-form(v-model="comment")
    el-form-item
      el-col(:xs="24" :md="4" :lg="4" :sm="12")
        label Chọn đánh giá của bạn
      el-col(:xs="24" :md="20" :lg="20" :sm="12")
        span.star(v-for="item in 5" :key="item" v-on:mouseover="changeComment(item)" :class="{'check': item <= comment.rating}")
          svg-icon(icon-class="fa-solid star")
      el-input(type="hidden" v-model="comment.rating" style="display: none")
    el-form-item
      el-input(type="textarea" placeholder="Nhập đánh giá về sản phẩm. Chất lượng, giao hàng,..." rows="5")
    el-form-item
      el-button(type="primary") Gủi đánh giá
</template>

<script>
  export default {
    name: 'CommentForm',
    data () {
      return {
        comment: {
          rating: 5,
          content: ''
        }
      }
    },
    methods: {
      changeComment (value) {
        this.comment.rating = value
      }
    }
  }
</script>
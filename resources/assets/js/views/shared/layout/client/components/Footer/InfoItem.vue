<template lang="pug">
  div.footer-item
    h4.footer-item__title {{title}}
    div.footer-item__content
      slot(name="footer-content")
</template>

<script>
  export default {
    name: 'InfoItem',
    props: {
      title: {
        type: String,
        default: 'Tiêu đề'
      }
    }
  }
</script>
<template lang="pug">
  div.footer-item
    h4.footer-item__title {{item && item.title || 'Tiêu đề'}}
    div.footer-item__content
      slot(name="footer-content")
</template>

<script>
  export default {
    name: 'InfoItem',
    props: {
      item: {
        type: Object,
        default: () => {}
      }
    }
  }
</script>
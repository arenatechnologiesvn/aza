<template lang="pug">
    el-dialog.media-modal(:visible.sync="dialogVisible" width="60%")
      media-manager
      span.dialog-footer(slot="footer")
        el-button(@click="dialogVisible = false") Hủy
        el-button(type="primary" @click="dialogVisible = false") Thay đổi
</template>

<script>
import MediaManager from '~/components/MediaManager'

export default {
  name: 'media-manager-modal',
  components: {
    MediaManager
  },
  data() {
    return {
      dialogVisible: false
    }
  }
}
</script>


<style rel="stylesheet/scss" lang="scss" scoped>
.media-modal {
  .el-dialog__header {
    display: none;
  }

  .el-dialog__body {
    padding: 0;
  }
}
</style>

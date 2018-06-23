<template lang="pug">
    el-dialog.media-modal(:visible.sync="dialogVisible" width="60%")
      media-manager(:type="type" ref="mediaManager")
      span.dialog-footer(slot="footer")
        el-button(size="medium" @click="closeModal")
          svg-icon(icon-class="fa-solid ban")
          span  Hủy
        el-button(type="primary" size="medium" @click="setSelectedImage")
          svg-icon(icon-class="fa-solid check")
          span  Thay đổi
</template>

<script>
import MediaManager from '~/components/MediaManager'

export default {
  name: 'media-manager-modal',
  components: {
    MediaManager
  },
  model: {
    prop: 'selectedMediaUrl',
    event: 'click'
  },
  props: {
    type: {
      type: String,
      required: true
    },
    selectedMediaUrl: String
  },
  data() {
    return {
      dialogVisible: false,
    }
  },
  methods: {
    setSelectedImage() {
      const url = this.$refs.mediaManager.selectedImageUrl();

      // send url to parent model
      this.$emit('click', url);

      // close modal
      this.closeModal();
    },
    closeModal() {
      this.dialogVisible = false;
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

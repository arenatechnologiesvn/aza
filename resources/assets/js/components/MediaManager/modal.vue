<template lang="pug">
    el-dialog.media-modal(:visible.sync="visible" width="60%")
      media-manager(:type="type" ref="mediaManager")
      span.dialog-footer(slot="footer")
        el-button(type="primary" size="small" @click="setSelectedImage" :disabled="!previewImageUrl")
          svg-icon(icon-class="fa-solid check")
          span  Thay đổi
        el-button(size="small" type="info" @click="closeModal")
          svg-icon(icon-class="fa-solid ban")
          span  Hủy
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import MediaManager from '~/components/MediaManager'

export default {
  name: 'media-manager-modal',
  components: {
    MediaManager
  },
  props: {
    type: {
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters({
      selectedImage: 'media/selectedMedia',
      previewImage: 'media/previewMedia',
      previewImageUrl: 'media/previewMediaUrl'
    }),

    ...mapState({
      dialogVisible: state => state.common.media.dialogVisible
    })
  },
  data() {
    return {
      visible: false
    }
  },
  methods: {
    setSelectedImage() {
      this.setMedia(this.previewImage);

      // close modal
      this.closeModal();
    },
    ...mapActions({
      closeModal: 'common/closeMediaManagerModal',
      setMedia: 'media/setMedia'
    })
  },
  watch: {
    visible() {
      if (!this.visible) this.closeModal();
    },

    dialogVisible() {
      this.visible = this.dialogVisible;
    }
  }
}
</script>


<style rel="stylesheet/scss" lang="scss">
.media-modal {
  .el-dialog__header {
    display: none;
  }

  .el-dialog__body {
    padding: 0;
  }
}
</style>

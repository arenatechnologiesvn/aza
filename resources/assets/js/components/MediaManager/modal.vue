<template lang="pug">
    el-dialog.media-modal(:visible.sync="visible" width="60%")
      media-manager(:type="type" select-mode="selectMode" ref="mediaManager")
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
    },
    selectMode: {
      type: String,
      default: () => {
        return 'single'
      }
    }
  },
  computed: {
    ...mapGetters({
    }),

    ...mapState({
      dialogVisible: state => state.common.media.dialogVisible,
      mediaList: state => state.media.mediaList
    })
  },
  data() {
    return {
      visible: false
    }
  },
  methods: {
    setMedia() {
      // close modal
      this.closeModal();
    },

    ...mapActions({
      closeModal: 'common/closeMediaManagerModal',
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

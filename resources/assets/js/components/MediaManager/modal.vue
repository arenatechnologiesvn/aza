<template lang="pug">
    el-dialog.media-modal(:visible.sync="visible" width="60%")
      media-manager(:type="type" :select-mode="selectMode" ref="mediaManager")
</template>

<script>
import { mapActions, mapState } from 'vuex';
import MediaManager from '~/components/MediaManager';

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
    ...mapState({
      dialogVisible: state => state.common.media.dialogVisible,
      selectMode: state => state.common.media.mode
    })
  },
  data() {
    return {
      visible: false
    }
  },
  methods: {
    ...mapActions({
      closeModal: 'common/closeMediaManagerModal',
    })
  },
  watch: {
    visible() {
      if (!this.visible) {
        this.closeModal();
        this.$refs.mediaManager.clearAllSelected();
      }
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

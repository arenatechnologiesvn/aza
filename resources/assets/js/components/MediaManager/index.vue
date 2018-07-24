<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid images")
        span(slot="label")  Quản lý File
      el-row(type="flex" justify="end" :gutter="10" style="padding: 0 10px 10px")
        el-col(:span="6")
          el-input(size="small" placeholder="Tìm kiếm")
            i(slot="suffix" class="el-input__icon el-icon-search")
        el-col(:span="6")
          el-button(type="primary" size="small" @click="handleSelectedMedia" :disabled="!isHaveSelected()")
            svg-icon(icon-class="fa-solid check")
            span  Thay đổi
          el-button(size="small" type="info" @click="closeModal")
            svg-icon(icon-class="fa-solid ban")
            span  Hủy
          // el-button(type="danger" size="small" @click="deleteMedia" disabled)
          //   svg-icon(icon-class="fa-solid trash-alt")
          //   span  Xóa
      el-container.media-container
        el-container
          el-aside.aside-container(width="200px")
            img.aside-image(:src="previewMediaUrl")
            el-row.aside-info
              .row-info
                span.image-info Tên
                span(v-if="previewMedia") {{ previewMedia.filename }}.{{ previewMedia.extension }}
              .row-info
                span.image-info Size
                span(v-if="previewMedia") {{ bytesToSize(previewMedia.size) }}
              .row-info
                span.image-info Loại file
                span(v-if="previewMedia") {{ previewMedia.mime_type }}
          el-main
            div.clearfix
              ul.__file-box-container
                li.attach-image(v-for="(media, index) in medias" :key="index")
                  div.__file-box(v-touch:tap="selectMedia(media)" :class="selectedClass(media)")
                    div.__box-data
                        div.__box-preview
                          div.__box-img
                            img(:src="'/' + media.directory + '/' + media.filename + '.' + media.extension")

                        div.__box-info
                          div
                            span {{ media.filename + '.' + media.extension }}
                          small.__info-file-size {{ bytesToSize(media.size) }}
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid upload")
        span(slot="label")  Upload File
      dropzone(ref="azaVueDropzone" id="dropzone" :options="dropzoneOptions" v-on:vdropzone-success="showSuccess")
</template>

<script>
  import { mapGetters, mapActions } from 'vuex';
  import { getToken } from '~/utils/auth';
  import Dropzone from 'vue2-dropzone';

  const MEDIA_UPLOAD_API = `http://${location.host}/api/media/upload`;
  const FILE_SIZES = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

  export default {
    name: 'media-manager',
    components: {
      Dropzone
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
        medias: 'media/list',
        previewMedia: 'media/previewMedia',
        previewMediaUrl: 'media/previewMediaUrl'
      })
    },
    created () {
      this.getMediaData();
    },
    data () {
      return {
        dropzoneOptions: {
          url: MEDIA_UPLOAD_API,
          thumbnailWidth: 150,
          maxFilesize: 0.5,
          headers: { Authorization: `Bearer ${getToken()}` },
          params: {
            type: this.type
          }
        },
        selectedMedia: null
      }
    },
    methods: {
      handleSelectedMedia() {
        this.setSelectedMedia({ mode: this.selectMode, selected: this.selectedMedia });
        this.closeModal();
      },

      selectMedia(media) {
        return () => {
          this.setPreviewMedia(media);
          this.handleTempSelectedMedia(media);
        };
      },

      handleTempSelectedMedia(media) {
        if (this.selectMode === "single") {
          this.selectedMedia = this.selectedMedia && this.selectedMedia === media.id ? null : media.id;
        } else {
          if (!this.selectedMedia) this.selectedMedia = [];
          if (this.selectedMedia.includes(media.id)) {
            const index = this.selectedMedia.indexOf(media.id);
            this.selectedMedia.splice(index, media.id);
          } else {
            this.selectedMedia.push(media.id);
          }
        }
      },

      getMediaData() {
        this.fetchMedia(this.type);
      },

      showSuccess(file, response) {
        this.getMediaData();
      },

      bytesToSize(bytes) {
        if (bytes === '') return '';
        if (bytes === 0) return '0 Byte';
        const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + FILE_SIZES[i];
      },

      selectedClass(media) {
        if (this.selectMode === "single") {
          return this.selectedMedia && this.selectedMedia === media.id ? 'selected' : '';
        } else {
          return this.selectedMedia && this.selectedMedia.includes(media.id) ? 'selected' : '';
        }
      },

      isHaveSelected() {
        return !!this.selectedMedia;
      },

      clearAllSelected() {
        this.selectedMedia = null;
      },

      deletemedia() {
        deleteMedia(this.type, this.selectedmedia.id).then(() => {
          this.getMediaData();
        }).catch(error => {
          // Do nothing
        });
      },

      // handleImageMetaDataSave() {
      //   this.currentImage.meta_data.currentImageId = this.currentImage.id
      //   this.$http.post(metaDataSave, this.currentImage.meta_data)
      //     .then(response => {
      //       console.log('response', response)
      //     }).catch(error => {
      //       console.log('error', error)
      //   })
      // },

      ...mapActions({
        fetchMedia: 'media/fetchMedia',
        setSelectedMedia: 'media/setSelectedMedia',
        setPreviewMedia: 'media/setPreviewMedia',
        closeModal: 'common/closeMediaManagerModal'
      })
    }
  }
</script>

<style lang="scss" scoped>
  // theme
  $light_theme: #eceff1;
  $dark_theme: invert($light_theme);
  $active_theme: $light_theme;

  // colors
  $white: lighten($active_theme, 100%);
  $black: darken($active_theme, 80%);
  $green: hsl(141, 71%, 48%);
  $yellow: hsl(48, 100%, 67%);
  $red: hsl(348, 100%, 61%);
  $blue: hsl(217, 71%, 53%);
  $shadow_1: 0 10px 45px 0 rgba($black, 0.2);
  $shadow_2: 0 6px 25px 0 rgba($black, 0.3);
  $shadow_3: 0 6px 10px rgba($black, 0.08);

  .attach-image {
    list-style: none;
    float: left;
    padding: 8px;
    margin: 0;
    width: 200px;
  }

  .media-container {
    height: 400px;
    border: 1px solid #e4e7ed;

    .aside-container {
      background-color: rgb(238, 241, 246);

      .aside-image {
        width: 200px;
        height: 200px;
        background: #909399;
        border-right: 1px solid #e4e7ed;
        border-bottom: 1px solid #e4e7ed;
      }

      .aside-info {
        padding: 10px 0 0 10px;
        font-size: 12px;

        .row-info {
          margin-top: 3px;

          .image-info {
            font-weight: bold;
            background: #909399;
            padding: 4px 5px 4px;
            border-color: #909399;
            border-radius: 3px;
            color: white;
            margin-right: 3px;
          }
        }
      }
    }
  }

  .el-tabs--border-card {
    border: none;
    box-shadow: none;
    -webkit-box-shadow: none;
  }

  .__file-box-container {
    display: inline-block;
    padding: 0;
    margin-top: 0;

    .__file-box {
      position: relative;
      overflow: hidden;
      width: 100%;
      padding: 0.2rem;
      cursor: pointer;
      transition: all 0.25s;
      color: darken($active_theme, 60%);
      border: 1px solid darken($active_theme, 2.5%);
      border-radius: 4px;
      background: lighten($active_theme, 2.5%);
      line-height: 1.4;

      &.selected,
      &.bulk-selected {
        color: $white;
        border-color: darken($blue, 5%);
        background: $blue;

        h4,
        i,
        svg {
          color: $white;
        }
      }

      &:hover {
        box-shadow: $shadow_1;
      }
    }

    .__box-data {
      display: flex;
      overflow: hidden;
      align-items: center;
      align-self: flex-end;
      justify-content: start;
      width: 100%;

      .__box-preview {
        margin: 0 0.75rem 0 1px;
        color: darken($active_theme, 50%);

        .icon {
          transform: translateY(3px);
        }

        .__box-img {
          overflow: hidden;
          width: 50px;
          height: 50px;
          border-radius: 3px;

          img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            object-position: center;
          }
        }
      }

      .__box-info {
        overflow: hidden;
        width: 100%;

        span {
          font-size: 11px;
          overflow: hidden;
          margin: 0;
          white-space: nowrap;
          text-overflow: ellipsis;
        }

        small {
          font-size: 11px;
        }

        .__info-file-size {
          font-weight: bold;
          margin-left: 2px;
        }
      }
    }
  }
</style>

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
        el-col(:span="2" v-if="images.length")
          el-button(type="danger" size="small" @click="deleteImage")
            svg-icon(icon-class="fa-solid trash-alt")
            span  Xóa
      el-container.media-container
        el-aside.aside-container(width="200px")
          div(v-if="images.length > 0")
            img.aside-image(:src="selectedImageUrl()")
            el-row.aside-info
              div
                span(style="font-weight: bold") Tên:
                span  {{ currentImage.filename }}.{{ currentImage.extension }}
              div
                span(style="font-weight: bold") Size:
                span  {{ bytesToSize(currentImage.size) }}
              div
                span(style="font-weight: bold") Loại file:
                span  {{ currentImage.mime_type }}
        el-main
          div.clearfix
            ul
              li.attach-image(v-for="(image, index) in images" :key="index")
                div.__file-box(v-touch:tap="selectImage(image)" :class="[image.id == currentImage.id ? 'selected': '']")
                  div.__box-data
                      div.__box-preview
                        div.__box-img
                          img(:src="image.directory + '/' + image.filename + '.' + image.extension"
                            v-bind:alt="image.directory"
                            v-bind:title="(image.meta_data !== null) ? image.meta_data.alt : ''")

                      div.__box-info
                        div
                          span {{ image.filename + '.' + image.extension }}
                        small.__info-file-size {{ bytesToSize(image.size) }}
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid upload")
        span(slot="label")  Upload File
      dropzone(ref="azaVueDropzone" id="dropzone" :options="dropzoneOptions" v-on:vdropzone-success="showSuccess")
</template>

<script>
  import { getMedia, deleteMedia } from '~/api/media';
  import { getToken } from '~/utils/auth';
  import Dropzone from 'vue2-dropzone';

  const MEDIA_UPLOAD_API = `http://${location.host}/api/media/upload`;
  const FILE_SIZES = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

  export default {
    name: 'media-manager',
    components: {
      Dropzone
    },
    created () {
      this.getMediaData();
    },
    data () {
      return {
        images: [],
        currentImage: this.setCurrentImage(),
        dropzoneOptions: {
          url: MEDIA_UPLOAD_API,
          thumbnailWidth: 150,
          maxFilesize: 0.5,
          headers: { Authorization: `Bearer ${getToken()}` },
          params: {
            type: 'profile'
          }
        }
      }
    },
    methods: {
      setCurrentImage() {
        return {
          directory: '',
          filename: '',
          extension: '',
          meta_data: {
            alt: '',
            caption: '',
            currentImageId: null
          }
        };
      },
      showSuccess(file, response) {
        this.getMediaData();
      },
      handleImageDetails(image) {
        this.currentImage = image
        if (image.meta_data == null) {
          image.meta_data = {
            alt: '',
            caption: '',
            currentImageId: image.id
          };
        } else {
          (typeof image.meta_data === 'object') ? this.currentImage.meta_data = image.meta_data : this.currentImage.meta_data = JSON.parse(image.meta_data);
        }
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
      bytesToSize(bytes) {
        if (bytes == 0) return '0 Byte';
        const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + FILE_SIZES[i];
      },
      selectImage(image) {
        return () => {
          this.handleImageDetails(image);
        };
      },
      getMediaData() {
        getMedia('profile').then(response => {
          this.images = response.data;

          if (this.images.length) {
            this.handleImageDetails(this.images[0]);
          }
        })
      },
      selectedImageUrl() {
        return `${this.currentImage.directory}/${this.currentImage.filename}.${this.currentImage.extension}`;
      },
      deleteImage() {
        deleteMedia('profile', this.currentImage.id).then(() => {
          this.getMediaData();
        })
      }
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
    border: 1px solid rgb(238, 238, 238);

    .aside-container {
      background-color: rgb(238, 241, 246);

      .aside-image {
        width: 200px;
        height: 200px;
      }

      .aside-info {
        padding: 10px 0 0 10px;
      }
    }
  }

  .el-tabs--border-card {
    border: none;
    box-shadow: none;
    -webkit-box-shadow: none;
  }

  .__file-box {
    position: relative;
    display: flex;
    overflow: hidden;
    width: 100%;
    padding: 0.5rem;
    cursor: pointer;
    transition: all 0.25s;
    color: darken($active_theme, 60%);
    border: 1px solid darken($active_theme, 2.5%);
    border-radius: 4px;
    background: lighten($active_theme, 2.5%);
    line-height: 1.4;

    &.selected,
    &.bulk-selected,
    &:hover {
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
</style>
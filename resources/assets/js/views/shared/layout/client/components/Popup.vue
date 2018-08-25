<template lang="pug">
  el-dialog.popup-dialog(width="50%" center :visible.sync="pShow" lock-scroll :close-on-press-escape="false" :close-on-click-modal="false" )
    div.popup
      div.popup--left
        h4.popup--title
          span {{popup.title}}
        div
          span.popup--discount -{{popup.discount}}
          span.popup--percent %
        div
          span.popup--product {{popup.content}}
      div.popup--right(style="min-height: 200px;")
        span.close(@click="onClose") X
</template>

<script>
  export default {
    name: 'Popup',
    data () {
      return {
        pShow: false
      }
    },
    props: {
      popup: {
        type: Object,
        default: () => ({
          show: false,
          title: '',
          content: '',
          discount: '',
          url: ''
        })
      }
    },
    methods: {
      onClose (){
        this.pShow = false
      },
      fShow () {
        this.pShow = true
      }
    }
  }
</script>

<style lang="scss">
  .popup-dialog {
    .el-dialog {
      background-color: #ffffff;
      color: white;
      .el-dialog__body {
        padding: 0;
      }
      .el-dialog__header {
        display: none;
      }
      .popup {
        display: flex;
        flex-direction: row;
        flex: 2;
        color: white;
        text-align: center;
        position: relative;
        .popup--left {
          background-color: #83D5E0;
          padding: 25px 25px 30px;
        }
        .popup--title {
          margin: 0;
          padding: 10px;
          font-size: 17px;
          line-height: 25px;
          color: black;
          font-weight: bolder;
        }
        .popup--discount {
          font-size: 60px;
          font-weight: bolder;
          line-height: 70px;
          padding: 30px 5px;
          vertical-align: middle;
        }
        .popup--percent {
          font-size: 20px;
          vertical-align: middle;
          font-weight: lighter;
        }
        .close {
          position: absolute;
          right: 15px;
          top: 5px;
          color: black;
          font-size: 16px;
          cursor: pointer;
          &:hover {
            font-weight: bolder;
          }
        }
      }
    }
  }
</style>
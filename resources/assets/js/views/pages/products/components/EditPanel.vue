<template lang="pug">
//- KPI edit panel
.kpi-edit(:class="panelOpen ? 'kpi-edit--open' : ''" :style="{ top: handlePanelPosition() + 'px', height: handlePanelHeight() + 'px' }")
  .kpi-edit__inner
    .kpi-edit__controls
      div.control__item(:class="!productId ? 'control__item--disabled' : ''" @click="handlePanelClick")
        svg-icon(icon-class="fa-solid angle-double-left")
    .kpi-edit__content
      .kpi-edit__header
        el-tooltip(class="item" effect="dark" :content="title" placement="bottom")
          span.header-text {{ title }}
      .kpi-edit__form

      .kpi-edit__save
        el-button(type="primary" size="mini")
          svg-icon(icon-class="fa-solid save")
          span  Lưu
        el-button(type="info" size="mini")
          svg-icon(icon-class="fa-solid ban")
          span  Hủy
</template>
<script>
const panelDefaultPosition = 263;

export default {
  name: 'edit-panel',
  components: {

  },
  watch: {

  },
  data() {
    return {
      scrolled: 0,
      userHeight: 0,
      panelOpen: false
    };
  },
  computed: {
    title() {
      return 'AZA Project';
    }
  },
  methods: {
    handlePanelClick() {

    },
    handlePageScroll() {
      this.scrolled = window.scrollY;
    },
    handlePanelPosition() {
      const panelScrolledPosition = panelDefaultPosition - this.scrolled;

      return (panelScrolledPosition > 0) ? panelScrolledPosition : 0;
    },
    handlePanelHeight() {
      const panelHeight = (window.innerHeight - panelDefaultPosition) + this.scrolled;

      if (panelHeight < window.innerHeight) return panelHeight;
      return window.innerHeight;
    },
    // save() {
    //   this.handlePanelOpen();
    // },
    // cancel() {
    //   this.handlePanelOpen();
    // },
  },
  created () {
    window.addEventListener('scroll', this.handlePageScroll);
  },
  destroyed () {
    window.removeEventListener('scroll', this.handlePageScroll);
  }
};
</script>

<style lang="scss" scoped>
.kpi-edit {
  position: fixed;
  top: 17%;
  right: -20px;
  z-index: 9;
  height: 100%;
  width: 720px;
  -webkit-transform: translateX(92.5%);
  transform: translateX(92.5%);
  -webkit-transition: -webkit-transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1);
  transition: -webkit-transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1);
  transition: transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1);
  transition:
    transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1),
    -webkit-transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1);

  &--open {
    transform: translateX(0);
  }

  &__inner {
    position: relative;
    height: 100%;
  }

  &__controls {
    position: absolute;
    background: #001C2C;
    height: 100%;
    z-index: 15;
  }

  .control__item {
    padding: 8px;
    height: 45px;
    color: #fff;
    font-size: 20px;
    border-bottom: 1px solid #e3e4e7;
    list-style-type: none;
    cursor: pointer;

    &.control__item--disabled {
      background: #828793;
      color: #adb1b9;
      cursor: not-allowed;
    }
  }

  &__content {
    position: relative;
    padding-left: 36px;
    width: 100%;
    height: 100%;
    box-shadow: -3px 0 10px rgba(0, 0, 0, 0.2);
  }

  &__header {
    width: 100%;
    height: 44px;
    padding: 12px 8px;
    background: #001C2C;
    color: #fff;
    text-overflow: ellipsis;
    overflow: hidden;

    .header-text {
      color: #fff;
      font-weight: bold;
      white-space: nowrap;
    }
  }

  &__form {
    padding: 16px 16px 55px;
    height: 90%;
    width: 100%;
    background: #f1f1f1;
    overflow-y: scroll;

    &-item {
      margin-bottom: 10px;
      padding: 10px;
      background: #fff;
      border: 1px solid #f6f6f6;
      border-radius: 5px;
    }
  }

  &__save {
    position: absolute;
    bottom: 0;
    width: 92.4%;
    background: #fff;
    padding: 15px;
    text-align: right;
    border-top: 1px solid #f1f1f1;

    .btn {
      margin-right: 5px;
    }
  }

  .fade-enter-active,
  .fade-leave-active {
    max-height: 100%;
    transition: all 0.1s ease-in;
  }

  .fade-enter,
  .fade-leave-to {
    opacity: 0;
    transition: all 0.1s ease-out;
  }
}

.kpi-edit /deep/ {
  .kpi-field {
    margin-left: 20px;
    margin-bottom: 10px;

    label {
      margin-right: 10px;
    }

    .form-group {
      margin-right: 20px;

      &:last-child {
        margin-right: 0;
      }
    }

    .open .dropdown-menu {
      width: 350px;

      &.dropdown-menu-right {
        width: 280px;
      }
    }
  }

  .kpi-edit__form-item {
    .header-text {
      font-size: 12px;
      font-weight: bold;
    }

    .shr-heading-has-border-bottom {
      margin-bottom: 15px;
    }
  }
}
</style>

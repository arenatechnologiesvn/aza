<template lang="pug">
  div.app-page-title-panel
    el-row
      span.app-page-title {{ pageTitle }}
    el-row
      el-breadcrumb.app-breadcrumb(separator="|")
        transition-group(name="breadcrumb")
          el-breadcrumb-item(v-for="(item, index) in levelList" :key="item.path" v-if="item.meta.title")
            span.no-redirect(v-if="item.redirect === 'noredirect' || index === (levelList.length - 1)") {{ item.meta.title.toUpperCase() }}
            router-link(v-else :to="item.redirect || item.path") {{ item.meta.title.toUpperCase() }}
</template>

<script>
export default {
  created() {
    this.getBreadcrumb();
  },
  data() {
    return {
      pageTitle: '',
      levelList: null
    };
  },
  watch: {
    $route() {
      this.getBreadcrumb();
    }
  },
  methods: {
    getBreadcrumb() {
      let matched = this.$route.matched.filter(item => item.name);
      const first = matched[0];
      if (first && first.name === 'Dashboard') {
        matched = [{ path: '/dashboard', meta: { title: 'Dashboard' }}];
      }
      this.levelList = matched;
      this.pageTitle = matched.slice().pop().meta.title.toUpperCase();
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  .app-breadcrumb.el-breadcrumb {
    display: inline-block;
    font-size: 13px;
    line-height: 30px;
    color: #4a94fe;
    .no-redirect {
      color: #4a94fe;
      cursor: text;
    }
  }
  .app-page-title-panel {
    background-color: #dff6fd;
    padding: 10px 10px 0 10px;
    .app-page-title {
      color: #000;
      font-size: 18px;
    }
  }
</style>

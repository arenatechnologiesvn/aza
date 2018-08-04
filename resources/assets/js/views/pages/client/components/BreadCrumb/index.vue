<template lang="pug">
  div.breadcrumb__container
    h2.title__page {{$route.meta && $route.meta.title}}
    el-breadcrumb.breadcrumb(separator="/")
      transition-group(name="breadcrumb")
        el-breadcrumb-item(v-for="(item, index) in levelList" :key="item.path" v-if="item.meta.title")
          span.no-redirect(v-if="item.redirect === 'noredirect' || index === (levelList.length - 1)") {{ item.meta.title.toUpperCase() }}
          router-link(v-else :to="item.redirect || '/' + item.path") {{ item.meta.title.toUpperCase() }}
</template>

<script>
  import './breadcrumb.scss'
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
        if (first && first.name === 'home') {
          matched = [{ path: '', meta: { title: 'Trang chủ' }}];
        }else {
          matched.unshift({ path: '', meta: { title: 'Trang chủ' }})
        }
        this.levelList = matched;
        this.pageTitle = matched.slice().pop().meta.title.toUpperCase();
      }
    }
  }
</script>
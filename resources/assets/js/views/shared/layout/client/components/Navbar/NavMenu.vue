<template lang="pug">
  div
    el-menu(:default-active="$route.name" mode="horizontal"  background-color="#fff" text-color="#333" :router="true" class="hidden-md-and-down")
      el-menu-item(index="home" :route="{name: 'home'}") TRANH CHỦ
      el-menu-item(index="home_introduce" :route="{name: 'home_introduce'}") GIỚI THIỆU
      el-submenu(index="3")
        template(slot="title") SẢN PHẨM
        el-menu-item(index="home_product" v-for="item in categories" :key="item.id" :route="{name: 'home_product', query: {category: item.name}}") {{item.name}}
      el-menu-item(index="home_post" :route="{name: 'home_post'}") TIN TỨC
      el-menu-item(index="home_contact" :route="{name: 'home_contact'}") LIÊN HỆ
    el-menu.show-xs.menu-mobile(:default-active="$route.name" mode="vertical" :class="isShow? 'isShow' : ''"  background-color="#fff" text-color="#333" :router="true")
      el-menu-item(index="home" :route="{name: 'home'}") TRANH CHỦ
      el-menu-item(index="home_introduce" :route="{name: 'home_introduce'}") GIỚI THIỆU
      el-submenu(index="3")
        template(slot="title") SẢN PHẨM
        el-menu-item(index="home_product" :route="{name: 'home_product'}") THỰC PHẨM TƯỚI SỐNG
      <!--el-menu-item(index="product_detail" :route="{name: 'product_detail', params: {id: 2}}") TIN TỨC-->
      el-menu-item(index="home_post" :route="{name: 'home_post'}") TIN TỨC
      el-menu-item(index="home_contact" :route="{name: 'home_contact'}") LIÊN HỆ
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  export default {
    name: 'NavbarMenu',
    props: {
      isShow: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters('categories', {
        getList: 'list'
      }),
      categories () {
        console.log(this.getList)
        return this.getList
      }
    },
    methods: {
      ...mapActions('categories', {
        fetchCategories: 'fetchList'
      }),
      fetchData () {
        this.fetchCategories()
      }
    },
    created () {
      this.fetchData()
    }
  }
</script>

<style scoped>

</style>
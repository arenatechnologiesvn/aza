<template lang="pug">
  el-menu(:default-active="$route.name" mode="horizontal"  background-color="#fff" text-color="#333" :router="true")
    el-menu-item(index="home" :route="{name: 'home'}") TRANH CHỦ
    el-menu-item(index="2") GIỚI THIỆU
    <!--el-menu-item(index="home_product" :route="{name: 'home_product'}") GIỚI THIỆU-->
    el-submenu(index="3")
      template(slot="title") SẢN PHẨM
      el-menu-item(index="3-1") THỰC PHẨM TƯỚI SỐNG
    <!--el-menu-item(index="product_detail" :route="{name: 'product_detail', params: {id: 2}}") TIN TỨC-->
    el-menu-item(index="5") TIN TỨC
    el-menu-item(index="5") LIÊN HỆ
</template>

<script>
  export default {
    name: 'NavbarMenu'
  }
</script>

<style scoped>

</style>
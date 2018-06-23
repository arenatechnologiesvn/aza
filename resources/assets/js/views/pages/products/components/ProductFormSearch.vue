<template lang="pug">
  div.form-search__wrapper
    el-form.search
      el-row(style="margin: 0 -10px;")
        el-col(:span="16")
          el-form-item
            el-input(placeholder="Tìm kiếm" v-model="search.key" suffix-icon="el-icon-search" style="width: 100%")
        el-col(:span="4")
          el-form-item
            el-select(placeholder="Danh mục" v-model="search.category_id" )
              el-option(label="Vai trò 1" value="1")
              el-option(label="Vai trò 2" value="2")
        el-col(:span="4")
          el-form-item
            el-select(placeholder="Nhà cung cấp" v-model="search.company_id")
              el-option(label="Chưa kích hoạt" value="1")
              el-option(label="Đang hoạt động" value="2")
              el-option(label="Đang bị khóa" value="3")
</template>

<script>
  export default {
    name: 'ProductFormSearch',
    props: {
      search: {
        type: Object,
        default: () => {
          return {
            key: '',
            category_id: 0,
            company_id: 0
          }
        }
      }
    }
  }
</script>

<style scoped>

</style>
<template lang="pug">
  div.form__container
    el-card
      div.clearfix(slot="header")
        span
          svg-icon(icon-class="fa-solid th-list")
          span(style="margin-left: 10px;") Thêm mới danh mục sản phẩm
      el-row
        el-col(:span="14")
          el-form(:model="categoryForm" :rules="rules" ref="categoryForm" label-width="120px")
            el-form-item(label="Mã danh mục" prop="code")
              el-input(v-model="categoryForm.code" placeholder="Mã danh mục")
            el-form-item(label="Tên danh mục" prop="name")
              el-input(v-model="categoryForm.name" placeholder="Tên danh mục")
            el-row
              el-col(:span="22")
                el-form-item(label="Icon" prop="icon")
                  el-select(v-model="categoryForm.icon" clearable filterable placeholder="Icon" style="width: 100%")
                    el-option-group(v-for="group in icons" :key="group.label" :label="group.label")
                      el-option(v-for="item in group.options" :key="item.value" :label="item.label" :value="item.value")
                        span(style="float: left")
                          svg-icon(:icon-class="item.value")
                        span(style="float: right; color: #8492a6; font-size: 13px") {{ item.label }}
              el-col.icon-preview(:span="2")
                span(style="font-size: 32px; padding: 2px;")
                  svg-icon(:icon-class="categoryForm.icon")
            el-form-item(label="Mô tả" prop="description")
              el-input(type="textarea" v-model="categoryForm.description" rows="8" placeholder="Mô tả")

            el-form-item
              el-button(type="primary" size="small" @click="save")
                svg-icon(icon-class="fa-solid save")
                span  Lưu
              el-button(type="info" size="small" @click="cancel")
                svg-icon(icon-class="fa-solid ban")
                span  Hủy bỏ
</template>

<script>
  import { mapActions, mapState, mapGetters } from 'vuex';

  export default {
    name: 'CreateProduct',
    computed: {
      ...mapGetters({
        categoryById: 'categories/byId',
        getIcons: 'common/getIcons'
      }),

      ...mapState([
        'route'
      ])
    },
    data() {
      return {
        categoryForm: {
          code: '',
          name: '',
          icon: '',
          description: ''
        },
        rules: {
          code: [
            { required: true, message: 'Mã danh mục không được trống', trigger: 'blur' },
            { min: 1, max: 255, message: 'Chiều dài phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ],
          name: [
            { required: true, message: 'Tên danh mục không được trống', trigger: 'blur' },
            { min: 1, max: 255, message: 'Chiều dài phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ],
          icon: [
            { required: true, message: 'Icon không được trống', trigger: 'blur' }
          ],
          description: [
            { min: 1, max: 500, message: 'Chiều dài phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ]
        },
        icons: []
      }
    },
    methods: {
      save() {
        const confirmMessage = this.route.params.id ? 'Bạn có muốn cập nhật danh mục này không?' : 'Bạn có muốn tạo danh mục này không?';
        this.$confirm(confirmMessage, 'Xác nhận', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          this.$refs.categoryForm.validate((valid) => {
            if (valid) {
              if (this.route.params.id) {
                this.updateCategory({ id: this.route.params.id, data: this.categoryForm }).then(() => {
                  this.$router.push({ path: '/category' });
                });
              } else {
                this.createCategory({ data: this.categoryForm }).then(() => {
                  this.$router.push({ path: '/category' });
                });
              }
            }
          });
        });
      },

      cancel() {
        this.$confirm('Bạn có muốn hủy thao tác danh mục này không?', 'Xác nhận', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Hủy',
          type: 'warning'
        }).then(() => {
          this.$router.push({ path: '/category' });
        });
      },

      fetchData() {
        return this.fetchCategory({
          id: this.route.params.id
        }).then(() => {
          this.categoryForm = JSON.parse(JSON.stringify(this.categoryById(this.route.params.id)));
        }).catch(() => {
          this.$router.push({ path: '/category' });
        });
      },

      ...mapActions({
        createCategory: 'categories/create',
        fetchCategory: 'categories/fetchSingle',
        updateCategory: 'categories/update'
      })
    },
    watch: {
      route() {
        if (this.route.params.id) {
          this.fetchData();
        } else if (this.$refs.categoryForm) {
          this.$refs.categoryForm.resetFields();
        }
      }
    },
    created() {
      if (this.route.params.id) {
        this.fetchData();
      } else if (this.$refs.categoryForm) {
        this.$refs.categoryForm.resetFields();
      }

      this.icons = this.getIcons;
    }
  }
</script>

<style lang="scss">
  .el-form-item {
    &__error {
      padding: 2px 5px 0;
    }
  }
</style>

</<style lang="scss" scoped>
  .icon-preview {
    float: right;
    border-radius: 4px;
    border: 1px solid #dcdfe6;
    height: 40px;
    text-align: center;
    padding-right: 5px;
  }
</style>

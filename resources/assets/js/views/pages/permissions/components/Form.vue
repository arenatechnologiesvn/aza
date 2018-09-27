<template lang="pug">
  el-form(ref="form" v-model="permission" size="small")
    el-row
      el-col(:span="12")
        el-form-item(label="Tiêu đề ")
          el-input(v-model="permission.title" placeholder="Tiêu đề" clearable)
      el-col(:span="12")
        el-form-item(label="TÊN")
          el-input(v-model="permission.name" placeholder="Tên" clearable)
      el-col(:span="12")
        el-form-item(label="Cấp của quyền")
          el-input(v-model="permission.level" placeholder="Cấp của quyền" clearable)
      el-col(:span="12")
        el-form-item(label="Chuyển hướng")
          el-input(v-model="permission.redirect" placeholder="Chuyển hướng" clearable)
      el-col(:span="12")
        el-form-item(label="Url")
          el-input(v-model="permission.url_action" placeholder="Url" clearable)
      el-col(:span="12")
        el-form-item(label="Icon")
          el-input(v-model="permission.icon" placeholder="icon" clearable)
      el-col(:span="12")
        el-form-item(label="Đường dẫn")
          el-input(v-model="permission.path" placeholder="Đường dẫn" clearable)
      el-col(:span="12")
        el-form-item(label="Permission Cha")
          el-select(v-model="permission.parent_id" clearable filterable placeholder="Permission Cha" style="width: 100%")
            el-option(v-for="item in parentList" :key="item.id" :label="item.value" :value="item.id")
      el-col(:span="24")
        el-form-item
          el-checkbox(label="Là menu" v-model="permission.is_menu")
      el-col(:span="24")
        el-form-item
          el-checkbox(label="Cho phép hiển thị" v-model="permission.is_show")
      el-col(:span="24")
        el-form-item
          el-checkbox(label="Cần xác thực" v-model="permission.authorize")
      el-col(:span="24")
        el-form-item(style="text-align: right;")
          el-button(type="primary" @click="handleSubmit")
            svg-icon(icon-class="fa-solid save")
            span(style="margin-left: 10px") Lưu
          el-button(type="danger" @click="back")
            svg-icon(icon-class="fa-solid ban")
            span(style="margin-left: 10px") Hủy bỏ
</template>

<script>
  import { mapGetters, mapActions} from 'vuex'

  export default {
    name: 'PermissionForm',
    props: {
      permission: {
        type: Object,
        default: () => ({
          'level': 0,
          'name': '',
          'title': '',
          'url_action': '',
          'icon': '',
          'path': '',
          'redirect': '',
          'parent_id': null,
          'is_menu': false,
          'is_show': false,
          'authorize': false
        })
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters('permissions', {
        parents: 'list'
      }),
      parentList () {
        return this.parents.filter(item => item.id !== this.permission.id).map(item => {
          return {
            id: item.id,
            value: item.title
          }
        })
      }
    },
    methods: {
      back () {
        this.$router.go(-1)
      },
      ...mapActions('permissions', {
        listPermissions: 'fetchList',
        CreatePermission: 'create',
        UpdatePermission: 'update'
      }),
      update () {
        this.UpdatePermission({
          id: this.$route.params.id,
          data: this.permission
        }).then(res => {
          this.$router.push({name: 'permission_index', replace: true})
        }).catch(err => {
          this.$message.error('Error! Cannot update employee');
        })
      },
      create () {
        this.CreatePermission({
          data: this.permission
        }).then(res => {
          this.$router.push({name: 'permission_index', replace: true})
        }).catch(err => {
          this.$message.error('Error! Cannot create employee');
        })
      },
      handleSubmit () {
        this.isUpdate ? this.update() : this.create()
      }
    },
    created () {
      this.listPermissions()
    }
  }
</script>
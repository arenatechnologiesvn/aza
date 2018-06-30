<template lang="pug">
  div.form__wrapper
    el-form(ref="form" v-model="role")
      el-form-item(label="Tên quyền")
        el-input(v-model="role.title" v-bind:disabled="isUpdate")
      el-form-item(label="Mô tả")
        el-input(v-model="role.description" type="textarea" rows="3")
      el-form-item
        el-checkbox(label="Quyền thuộc nhân viên" v-model="role.is_employee")
      el-form-item(style="text-align: right;")
        el-button(type="primary" @click="handleSubmit")
          svg-icon(icon-class="fa-solid save")
          span(style="margin-left: 10px") Lưu
        el-button(type="danger" @click="back")
          svg-icon(icon-class="fa-solid ban")
          span(style="margin-left: 10px") Hủy bỏ
</template>

<script>
  import { mapActions } from 'vuex'
  export default {
    name: 'RoleForm',
    props: {
      role: {
        type: Object,
        default: () => {
          return {
            id: 0,
            title: '',
            description: '',
            is_employee: false
          }
        }
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      ...mapActions('roles', {
        createRole: 'create',
        updateRole: 'update'
      }),
      back () {
        this.$router.go(-1)
      },
      update () {
        this.updateRole({
          id: this.$route.params.id,
          data: this.role
        }).then(() => this.$router.push({name: 'roles', replace: true}))
          .catch(err => {
            console.log(err)
            this.$message.error('Error! Cannot update role')
          })
      },
      create () {
        this.createRole({
          data: this.role
        }).then(() => {
          this.$router.push({name: 'roles'})
        }).catch(err => {
          console.log(err)
          this.$message.error('Error! Cannot create role');
        })
      },
      handleSubmit () {
        this.isUpdate ? this.update() : this.create()
      }
    }
  }
</script>

<style scoped>

</style>
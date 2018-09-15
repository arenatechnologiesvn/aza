<template lang="pug">
  div.index__container
    div.table
      el-table(:data="permissions.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
        el-table-column(type="selection" width="40")
        el-table-column(prop="user.icon" width="60" style="text-align: center; margin: 0 auto;")
          template(slot-scope="scope")
            svg-icon(:icon-class="scope.row.icon || ''")
        el-table-column(prop="title" label="Tiêu đề" sortable min-width="200")
          template(slot-scope="scope")
            span {{'|==>'.repeat(scope.row.level - 1)}}
            span(style="margin-left: 5px;") {{scope.row.title}}
        el-table-column(prop="name" label="Tên permission" sortable width="250")
        el-table-column(prop="path" label="Đường dẫn" sortable width="300")
        el-table-column(prop="is_menu" label="Là Menu link" sortable width="120")
          template(slot-scope="scope")
            el-switch(v-model="!!scope.row.is_menu" @change="onChangeStatus(scope.row.id, scope.row.status)")
        el-table-column(prop="id" label="TÁC VỤ" width="130" fixed="right")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Chỉnh sửa" placement="top" v-if="editEnable")
              el-button(size="mini" @click="handleEdit(scope.row.id)" round)
                svg-icon(icon-class="fa-solid user-edit")
            el-tooltip(effect="dark" content="Xóa" placement="top")
              el-button(size="mini" type="danger" @click="onDelete(scope.row.id)" round)
                svg-icon(icon-class="fa-solid trash-alt")
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[1, 5, 10, 20, 40]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="permissions.length")

</template>

<script>
  import {checkPermission} from '~/utils/util'
  import {EDIT_ACTION} from '~/utils/const'
  export default {
    name: 'PermissionTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
      }
    },
    computed: {
      editEnable () {
        return checkPermission(EDIT_ACTION, this.$store.getters.mpermissions)
      }
    },
    props: {
      permissions: {
        type: Array,
        default: () => []
      },
      total: {
        type: Number,
        default: 0
      }
    },
    methods: {
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
      },
      handleEdit (id) {
        this.$emit('on-update', id)
      },
      onDelete (id) {
        this.$emit('on-delete', id)
      },
      onChangeStatus(id, status) {
        this.$emit('on-change-status', id, {
          status: !status
        })
      }
    }
  }
</script>
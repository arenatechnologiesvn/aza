<template lang="pug">
  div.index__container
    div.table
      el-table(:data="roles" border v-loading="loading"  style="width: 100%" size="small" @selection-change="selectChange")
        el-table-column(type="selection" width="40")
        el-table-column(prop="title" label="TÊN QUYỀN" sortable)
        el-table-column(prop="description" label="MÔ TẢ" sortable width="180")
        el-table-column(prop="id" label="TÁC VỤ" width="170")
          template(slot-scope="scope")
            el-button(type="warning" size="mini" @click="handleEdit(scope.row.id)")
              svg-icon(icon-class="fa-solid user-edit")
              span(style="margin-left: 5px") Sửa
            el-button(type="danger" size="mini")
              svg-icon(icon-class="fa-solid trash-alt")
              span(style="margin-left: 5px") Xóa
    <!--div.pagination__wrapper-->
      <!--el-pagination(@size-change="handleSizeChange"-->
        <!--@current-change="handleCurrentChange"-->
        <!--:current-page.sync="currentPage"-->
        <!--:page-sizes="[100, 200, 300, 400]"-->
        <!--:page-size="100"-->
        <!--layout="total, sizes, prev, pager, next"-->
        <!--:total="400")-->

</template>

<script>

  export default {
    name: 'RoleTable',
    data () {
      return {
        currentPage: 1,
        showDialog: false,
        selection: []
      }
    },
    props: {
      roles: {
        type: Array,
        default: () => []
      },
      total: {
        type: Number,
        default: 0
      },
      loading: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      handleSizeChange (size) {
        this.$emit('on-size-change', size)
      },
      handleCurrentChange (current) {
        this.$emit('on-current-change', current)
      },
      handleEdit (id) {
        this.$emit('on-update', id)
      },
      onDelete (id) {
        this.$emit('on-delete', id)
        this.showDialog = false
      },
      selectChange (selection) {
       this.$emit('on-selection', selection);
      }
    }
  }
</script>

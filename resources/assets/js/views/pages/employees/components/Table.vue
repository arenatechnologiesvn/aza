<template lang="pug">
  div.index__container
    div.table
      el-table(:data="employees.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" @selection-change="handleSelectionChange" border style="width: 100%" size="small")
        el-table-column(type="selection" width="40")
        el-table-column(prop="user.avatar" width="60")
          template(slot-scope="scope")
            img(:src="avatarUrl(scope.row.user)" :width="40" :height="40")
        el-table-column(label="TRẠNG THÁI" align="center" width="150")
          template(slot-scope="scope")
            el-tag(:type="accountStatusType(scope.row.user)") {{ accountStatusName(scope.row.user) }}
        el-table-column(prop="code" label="MÃ NHÂN VIÊN" sortable min-width="150")
        el-table-column(prop="user.full_name" label="HỌ TÊN" sortable min-width="200")
        el-table-column(prop="user.email" label="EMAIL" sortable width="180")
        el-table-column(prop="user.phone" label="ĐIỆN THOẠI" sortable width="120")
        el-table-column(prop="customers.length" label="SỐ KHÁCH HÀNG" sortable width="140"  :formatter="(row, column) => row.customers.length")
        el-table-column(prop="user.role.title" label="VAI TRÒ" sortable width="180")
        el-table-column(prop="user.address" label="ĐỊA CHỈ" sortable width="300")
          template(slot-scope="scope")
            span {{ scope.row.user.address || '-' }}
        el-table-column(prop="is_active" label="KHÓA/HOẠT ĐỘNG" align="center" width="150")
          template(slot-scope="scope")
            el-switch(
              v-if="scope.row.user.is_verified"
              v-model="scope.row.user.is_active"
              @change="onChangeActive(scope.row.user_id, scope.row.user.is_active)"
              active-color="#13ce66"
              inactive-color="#909399"
            )
            span(v-if="!scope.row.user.is_verified") {{ '-' }}
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
        :total="employees.length")

</template>

<script>
  import dummyImage from '~/assets/login_images/dummy-avatar.png';
  import {checkPermission} from '~/utils/util'
  import {EDIT_EMPLOYEE} from '~/utils/const'

  export default {
    name: 'EmployeeTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
      }
    },
    computed: {
      editEnable () {
        return checkPermission(EDIT_EMPLOYEE, this.$store.getters.mpermissions)
      }
    },
    props: {
      employees: {
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
        this.$emit('on-delete', { id })
      },
      onChangeActive(id, isActive) {
        this.$emit('on-change-active', id, {
          id: id,
          is_active: isActive
        })
      },
      avatarUrl(user) {
        if (user.avatar && user.avatar.length) return user.avatar[0].url;
        return dummyImage;
      },
      accountStatusType(user) {
        if (!user.is_verified) return 'warning';
        if (!user.is_active) return 'info';
        return 'success';
      },
      accountStatusName(user) {
        if (!user.is_verified) return 'Chưa kích hoạt';
        if (!user.is_active) return 'Đang tạm khóa';
        return 'Đang hoạt động';
      },
      handleSelectionChange(val) {
        this.$emit('on-selection-change', val)
      }
    }
  }
</script>
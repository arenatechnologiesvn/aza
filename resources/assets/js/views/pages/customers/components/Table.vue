<template lang="pug">
  div.index__container
    div.table
      el-table(:data="customers.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
        el-table-column(type="selection" width="40")
        el-table-column(prop="user.avatar" width="60")
          template(slot-scope="scope")
            img(:src="avatarUrl(scope.row.user)" width="40" height="40")
        el-table-column(label="TRẠNG THÁI" align="center" width="150")
          template(slot-scope="scope")
            el-tag(:type="accountStatusType(scope.row.user)") {{ accountStatusName(scope.row.user) }}
        el-table-column(prop="code" label="MSKH" sortable min-width="100")
        el-table-column(prop="user.full_name" label="TÊN KH" sortable min-width="200")
        el-table-column(prop="employee.user.full_name" label="NHÂN VIÊN SALE" sortable min-width="200")
          template(slot-scope="scope")
            span {{ scope.row.employee && scope.row.employee.user.full_name ? scope.row.employee.user.full_name : '-' }}
        el-table-column(prop="user.phone" label="SỐ ĐIỆN THOẠI" sortable min-width="180")
        el-table-column(label="VIP" align="center" width="100")
          template(slot-scope="scope")
            svg-icon(
              icon-class="fa-solid check-square"
              :class="scope.row.customer_type ? 'vip-customer-icon' : 'normal-customer-icon'")
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
        el-table-column(prop="id" label="TÁC VỤ" width="120" fixed="right")
          template(slot-scope="scope")
            el-tooltip(effect="dark" content="Chi tiết" placement="top")
              el-button(size="mini" @click="onEdit(scope.row.id)" round)
                svg-icon(icon-class="fa-solid user")
            el-tooltip(effect="dark" content="Xóa" placement="top")
              el-button(size="mini" type="danger" @click="onDelete(scope.row.id)" round)
                svg-icon(icon-class="fa-solid trash-alt")
    div.pagination__wrapper
      el-pagination(@size-change="handleSizeChange"
        @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-sizes="[5, 10, 20, 40]"
          :page-size="pageSize"
      layout="total, sizes, prev, pager, next"
        :total="customers.length")
</template>

<script>
  import dummyImage from '~/assets/login_images/dummy-avatar.png';

  export default {
    name: 'CustomerTable',
    data () {
      return {
        currentPage: 1,
        pageSize: 10
      }
    },
    props: {
      customers: {
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
      onEdit (id) {
        this.$emit('on-update', id)
      },
      onDelete (id) {
        this.$emit('on-delete', id)
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
      }
    }
  }
</script>

<style lang="scss" scoped>
.vip-customer-icon {
  color: #67C23A;
  font-size: 18px;
}

.normal-customer-icon {
  color: #909399;
  font-size: 18px;
}
</style>

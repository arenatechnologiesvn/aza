<template lang="pug">
  el-row
    el-col.side-form(:span="5")
      el-row.image-container
        img.image-preview(:src="avatarUrl()" width="100%")
      el-row(style="margin-top: 10px")
        el-button(type="success" size="small" @click="openMediaModal('single')") Thay đổi
    el-col(:span="19")
      el-form(ref="form" :rules="rules" :model="customer" size="small")
        el-col(:span="24")
          el-form-item(prop="code" label="MÃ KHÁCH HÀNG")
            el-input(v-model="customer.code" placeholder="Mã khách hàng")
        el-col(:span="24")
          el-form-item(prop="user.email" label="EMAIL")
            el-input(v-model="customer.user.email" clearable type="email" placeholder="Ví dụ: abc@gmail.com, ..." :disabled="isUpdate")
        el-col(:span="24")
          el-form-item(prop="user.name" label="TÊN ĐĂNG NHẬP")
            el-input(v-model="customer.user.name" clearable placeholder="Tên đăng nhập" :disabled="isUpdate")
        el-col(:span="12")
          el-form-item(prop="user.last_name" label="HỌ")
            el-input(v-model="customer.user.last_name" clearable placeholder="Họ")
        el-col(:span="12")
          el-form-item(prop="user.first_name" label="TÊN")
            el-input(v-model="customer.user.first_name" clearable placeholder="Tên")
        el-col(:span="24")
          el-form-item(prop="user.phone" label="ĐIỆN THOẠI CHÍNH")
            el-input(v-model="customer.user.phone" clearable placeholder="Ví dụ: 0123345373, ...")
        el-col(:span="24")
          el-form-item(prop="user.address" label="ĐỊA CHỈ")
            el-input(v-model="customer.user.address" clearable placeholder="Địa chỉ")
        el-col(:span="8")
          el-form-item(prop="province_code" label="TỈNH/TP:")
            province-select(v-model="customer.province_code")
        el-col(:span="8")
          el-form-item(prop="district_code" label="HUYỆN/QUẬN:")
            district-select(v-model="customer.district_code" :parent-code="customer.province_code")
        el-col(:span="8")
          el-form-item(prop="ward_code" label="XÃ/PHƯỜNG:")
            ward-select(v-model="customer.ward_code" :parent-code="customer.district_code")
        el-col(:span="8")
          el-form-item(prop="employee_id" label="NHÂN VIÊN SALE")
            el-select(v-model="customer.employee_id" clearable placeholder="Nhân viên" style="width: 100%")
              el-option(v-for="item in employeesList" :key="item.id" :label="item.name" :value="item.id")
        el-col(:span="8")
          el-form-item(label="LOẠI KHÁCH HÀNG (VIP/THƯỜNG)")
            el-select(v-model="customer.customer_type" clearable placeholder="Loại khách hàng" style="width: 100%")
              el-option(label="Vip" :value="1")
              el-option(label="Thường" :value="0")
        el-col(:span="8")
          el-form-item(label="KÍCH HOẠT TÀI KHOẢN")
            el-switch(
              v-model="customer.user.is_verified"
              active-color="#13ce66"
              inactive-color="#E6A23C"
              style="width: 100%"
            )
        el-col(:span="24" v-if="isUpdate")
          el-form-item(label="CỬA HÀNG")
            .control__wrapper
              el-row
                el-col(:span="24" style="text-align: right")
                  el-button(type="success" size="small" @click="redirectToAddingShop()")
                    svg-icon(icon-class="fa-solid plus-circle")
                    span.ml-5  Thêm cửa hàng
                  el-input(placeholder="Tìm kiếm" v-model="searchWord" suffix-icon="el-icon-search" style="max-width: 200px; margin-left: 5px;" size="small")
            .table
              el-table(:data="showingShops.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border  style="width: 100%" size="small")
                el-table-column(prop="num" label="STT" align="center" width="60")
                  template(slot-scope="scope")
                    span {{ (scope.$index + 1) + (currentPage - 1) * pageSize }}
                el-table-column(prop="name" label="TÊN" sortable min-width="200")
                el-table-column(prop="phone" label="ĐIỆN THOẠI" sortable min-width="140")
                el-table-column(prop="address" label="ĐỊA CHỈ" sortable min-width="200")
                el-table-column(prop="zone" label="KHU VỰC" sortable min-width="200")
            .pagination__wrapper
              el-pagination(@size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page.sync="currentPage"
                :page-sizes="[5, 10, 20, 30, 50]"
                :page-size="pageSize"
                layout="total, sizes, prev, pager, next"
                :total="showingShops.length")
        el-col(:span="24")
          el-form-item(style="text-align: right;")
            el-button(type="info" @click="back")
              svg-icon(icon-class="fa-solid arrow-left")
              span(style="margin-left: 5px") Quay lại
            el-button(type="primary" @click="handleSubmit")
              svg-icon(icon-class="fa-solid save")
              span(style="margin-left: 5px") Lưu
    media-manager-modal(type="user")
</template>

<script>
  import { mapGetters, mapActions } from 'vuex';
  import ProvinceSelect from '~/components/AdministrativeSelect/Province';
  import DistrictSelect from '~/components/AdministrativeSelect/District';
  import WardSelect from '~/components/AdministrativeSelect/Ward';
  import MediaManagerModal from '~/components/MediaManager/modal';
  import dummyImage from '~/assets/login_images/dummy-avatar.png';

  export default {
    name: 'CustomerForm',
    components: {
      ProvinceSelect,
      DistrictSelect,
      WardSelect,
      MediaManagerModal
    },
    props: {
      customer: {
        type: Object,
        default: () => {
          return {
            code: '',
            customer_type: 0,
            employee_id: null,
            zone: '',
            province_code: '',
            district_code: '',
            ward_code: '',
            shops: [],
            user: {
              avatar: [],
              email: '',
              name: '',
              first_name: '',
              last_name: '',
              phone: '',
              address: '',
              is_verified: false
            }
          }
        }
      },
      isUpdate: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters('employees', {
        employees: 'list'
      }),
      ...mapGetters('media', {
        selectedAvatar: 'selectedSingleMedia',
      }),
      ...mapGetters('administrative', {
        getZoneByProvince: 'getZoneByProvince',
        getZoneByDistrict: 'getZoneByDistrict',
        getZoneByWard: 'getZoneByWard'
      }),
      employeesList () {
        return this.employees.filter(item => parseInt(item.user.role_id) === 3).map(item => {
          return {
            id: item.id,
            name: item.user.full_name
          }
        })
      },
      showingShops() {
        return this.filteredShops(this.customer.shops)
      }
    },
    data() {
      return {
        currentPage: 1,
        pageSize: 5,
        searchWord: '',
        rules: {
          'user.email': [
            { required: true, message: 'Email không được trống', trigger: 'blur' },
            { type: 'email', message: 'Email không đúng', trigger: ['blur', 'change'] },
            { max: 255, message: 'Email phải nhỏ hơn 100 ký tự', trigger: 'blur' }
          ],
          'user.name': [
            { required: true, message: 'Tên đăng nhập không được trống', trigger: 'blur' },
            { max: 100, message: 'Tên đăng nhập phải nhỏ hơn 100 ký tự', trigger: 'blur' }
          ],
          code: [
            { required: true, message: 'Mã khách hàng không được trống', trigger: 'blur' },
            { max: 20, message: 'Mã khách hàng phải nhỏ hơn 20 ký tự', trigger: 'blur' }
          ],
          employee_id: [
            { required: true, message: 'Nhân viên sale không được trống', trigger: 'change' }
          ],
          'user.first_name': [
            { max: 50, message: 'Tên phải nhỏ hơn 50 ký tự', trigger: 'blur' }
          ],
          'user.last_name': [
            { max: 50, message: 'Họ phải nhỏ hơn 50 ký tự', trigger: 'blur' }
          ],
          'user.phone': [
            { max: 20, message: 'Điện thoại phải nhỏ hơn 20 ký tự', trigger: 'blur' }
          ],
          'user.address': [
            { max: 255, message: 'Địa chỉ phải nhỏ hơn 255 ký tự', trigger: 'blur' }
          ],
        }
      }
    },
    methods: {
      ...mapActions('employees', {
        fetchEmployees: 'fetchList'
      }),
      ...mapActions('customers', {
        createCustomer: 'create',
        updateCustomer: 'update'
      }),
      ...mapActions('common', {
        openMediaModal: 'openMediaManagerModal'
      }),
      back () {
        this.$router.go(-1)
      },
      update (params) {
        this.updateCustomer({
          id: this.$route.params.id,
          data: params
        }).then(() => {
          this.$notify({ title: 'Thông báo', message: 'Cập nhật thành công', type: 'success' });
          this.$router.push({ name: 'customer_index', replace: true })
        }).catch(() => {
          this.$notify({ title: 'Thông báo', message: 'Cập nhật thất bại', type: 'error' });
        })
      },
      create (params) {
        this.createCustomer({
          data: params
        }).then(() => {
          this.$notify({ title: 'Thông báo', message: 'Tạo mới thành công', type: 'success' });
          this.$router.push({ name: 'customer_index', replace: true })
        }).catch(() => {
          this.$notify({ title: 'Thông báo', message: 'Tạo mới thất bại', type: 'error' });
        })
      },
      handleSubmit () {
        this.$refs.form.validate((valid) => {
          if (valid) {
            const params = this.prepareParams();
            this.isUpdate ? this.update(params) : this.create(params)
          }
        })
      },
      prepareParams() {
        const params = {
          code: this.customer.code,
          customer_type: this.customer.customer_type,
          employee_id: this.customer.employee_id,
          zone: this.renderZone(),
          province_code: parseInt(this.customer.province_code),
          district_code: parseInt(this.customer.district_code),
          ward_code: parseInt(this.customer.ward_code),
          shops: this.getSelectedShopIds(),
          avatar: this.customer.user.avatar.length ? this.customer.user.avatar[0].id : null,
          user: {
            first_name: this.customer.user.first_name,
            last_name: this.customer.user.last_name,
            phone: this.customer.user.phone,
            address: this.customer.user.address,
            is_verified: this.customer.user.is_verified,
            role_id: 2
          }
        }

        if (!this.isUpdate) {
          params.user.email = this.customer.user.email;
          params.user.name = this.customer.user.name;
        } else {
          params.user.is_active = this.customer.user.is_verified;
        }

        return params;
      },
      renderZone() {
        if (this.customer.ward_code) {
          return this.getZoneByWard(this.customer.ward_code);
        }

        if (this.customer.district_code) {
          return this.getZoneByDistrict(this.customer.district_code);
        }

        if (this.customer.province_code) {
          return this.getZoneByProvince(this.customer.province_code);
        }

        return '';
      },
      getSelectedShopIds() {
        return this.customer.shops.map(shop => {
          return shop.id;
        });
      },
      avatarUrl() {
        return this.customer.user.avatar && this.customer.user.avatar.length ? this.customer.user.avatar[0].url : dummyImage;
      },
      filteredShops(data) {
        const filterWord = this.searchWord && this.searchWord.toLowerCase();

        if (filterWord !== '') {
          filterWord.trim().split(/\s/).forEach(word => {
            data = data.filter(item => {
              return item.name.toLowerCase().indexOf(word) > -1;
            });
          });
        }

        return data;
      },
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
      },
      redirectToAddingShop() {
        const routeData = this.$router.resolve({ name: 'shop_create', replace: true });
        window.open(routeData.href, '_blank');
      }
    },
    watch: {
      selectedAvatar() {
        if (this.selectedAvatar) {
          this.customer.user.avatar = [this.selectedAvatar];
        }
      }
    },
    created () {
      this.fetchEmployees()
    }
  }
</script>

<style lang="scss" scoped>
.side-form {
  text-align: center;
  padding-right: 10px;

  .image-container {
    position: relative;
    width: 100%;
    padding-top: 100%;
    margin-top: 10px;

    .image-preview {
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      border: 1px solid #dcdfe6;
    }
  }
}
</style>

<style lang="scss">
  .el-form-item {
    margin: 10px;

    &__error {
      padding: 2px 5px 0;
    }
  }
</style>

<template lang="pug">
  div.form__container
    el-card
      div.clearfix(slot="header")
        span
          svg-icon(icon-class="fa-solid th-list")
          span(style="margin-left: 10px") Thêm mới nhà cung cấp

      el-row
        el-col.side-form(:span="6")
          .image-container
            img.image-preview(:src="logoUrl()" width="100%")
          div(style="margin-top: 10px")
            el-button(type="success" size="small" @click="openMediaModal('single')") Thay đổi
        el-col(:span="18")
          el-form(ref="providerForm" :rules="rules" :model="providerForm" size="small")
            el-col(:span="24")
              el-form-item(prop="name" label="Tên nhà cung cấp:")
                el-input(v-model="providerForm.name" placeholder="Tên nhà cung cấp")
            el-col(:span="24")
              el-form-item(prop="code" label="Mã nhà cung cấp:")
                el-input(v-model="providerForm.code" placeholder="Mã nhà cung cấp")
            el-col(:span="12")
              el-form-item(prop="phone" label="Điện thoại di động:")
                el-input(v-model="providerForm.phone" placeholder="Ví dụ: 09876085....")
            el-col(:span="12")
              el-form-item(prop="home_phone" label="Điện thoại cố định:")
                el-input(v-model="providerForm.home_phone" placeholder="Ví dụ: 0236085...")
            el-col(:span="24")
              el-form-item(prop="address" label="Địa chỉ:")
                el-input(v-model="providerForm.address" placeholder="Ví du: 99 Lê Duẩn / Thôn 1 ...")
            el-col(:span="8")
              el-form-item(prop="province_code" label="Tỉnh/TP:")
                province-select(v-model="providerForm.province_code")
            el-col(:span="8")
              el-form-item(prop="district_code" label="Huyện/Quận:")
                district-select(v-model="providerForm.district_code" :parent-code="providerForm.province_code")
            el-col(:span="8")
              el-form-item(prop="ward_code" label="Xã/Phường:")
                ward-select(v-model="providerForm.ward_code" :parent-code="providerForm.district_code")
            el-col(:span="12")
              el-form-item(prop="contract_at" label="Ngày ký hợp đồng:")
                el-date-picker(
                  v-model="providerForm.contract_at"
                  type="date"
                  placeholder="Ngày ký hợp đồng"
                  format="dd-MM-yyyy"
                  value-format="dd-MM-yyyy"
                  size="small"
                  style="width: 100%"
                )
            el-col(:span="24")
              el-form-item(label="Mô tả" prop="description")
                el-input(type="textarea" v-model="providerForm.description" rows="8" placeholder="Mô tả")

            el-col(:span="24" )
              el-form-item(style="text-align: right")
                el-button(type="info" size="small" @click="cancel")
                  svg-icon(icon-class="fa-solid ban")
                  span  Hủy bỏ
                el-button(type="primary" size="small" @click="save")
                  svg-icon(icon-class="fa-solid save")
                  span  Lưu
    media-manager-modal(type="provider")
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';
import dummyImage from '~/assets/login_images/dummy-image.jpg';
import ProvinceSelect from '~/components/AdministrativeSelect/Province';
import DistrictSelect from '~/components/AdministrativeSelect/District';
import WardSelect from '~/components/AdministrativeSelect/Ward';
import MediaManagerModal from '~/components/MediaManager/modal';

export default {
  name: 'CreateProvider',
  components: {
    ProvinceSelect,
    DistrictSelect,
    WardSelect,
    MediaManagerModal
  },
  computed: {
    ...mapGetters({
      providerById: 'providers/byId',
      selectedLogo: 'media/selectedSingleMedia',
      getZoneByProvince: 'administrative/getZoneByProvince',
      getZoneByDistrict: 'administrative/getZoneByDistrict',
      getZoneByWard: 'administrative/getZoneByWard'
    }),

    ...mapState([
      'route'
    ])
  },
  data() {
    return {
      providerForm: {
        code: '',
        name: '',
        logo: null,
        description: '',
        address: '',
        zone: '',
        phone: '',
        home_phone: '',
        province_code: '',
        district_code: '',
        ward_code: '',
        contract_at: ''
      },
      rules: {
        code: [
          { required: true, message: 'Mã nhà cung cấp không được trống', trigger: 'blur' },
          { min: 1, max: 50, message: 'Chiều dài phải nhỏ hơn 50 ký tự', trigger: 'blur' }
        ],
        name: [
          { required: true, message: 'Tên nhà cung cấp không được trống', trigger: 'blur' },
          { min: 1, max: 100, message: 'Chiều dài phải nhỏ hơn 100 ký tự', trigger: 'blur' }
        ],
        description: [
          { min: 1, max: 500, message: 'Chiều dài phải nhỏ hơn 255 ký tự', trigger: 'blur' }
        ],
        address: [
          { min: 1, max: 255, message: 'Chiều dài phải nhỏ hơn 255 ký tự', trigger: 'blur' }
        ],
        phone: [
          { min: 1, max: 25, message: 'Chiều dài phải nhỏ hơn 15 ký tự', trigger: 'blur' }
        ],
        home_phone: [
          { min: 1, max: 25, message: 'Chiều dài phải nhỏ hơn 15 ký tự', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    save() {
      const confirmMessage = this.route.params.id ? 'Bạn có muốn cập nhật nhà cung cấp này không?' : 'Bạn có muốn tạo mới nhà cung cấp này không?';
      this.$confirm(confirmMessage, 'Xác nhận', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Hủy',
        type: 'success'
      }).then(() => {
        this.$refs.providerForm.validate((valid) => {
          if (valid) {
            const params = JSON.parse(JSON.stringify(this.providerForm));
            params.zone = this.renderZone();
            params.logo = this.providerForm.logo && this.providerForm.logo.id;
            if (this.route.params.id) {
              this.updateProvider({ id: this.route.params.id, data: params }).then(() => {
                this.$router.push({ path: '/products/providers' });
              });
            } else {
              this.createProvider({ data: params }).then(() => {
                this.$router.push({ path: '/products/providers' });
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
        this.$router.push({ path: '/products/providers' });
      }).catch(() => {
        // Do nothing
      });
    },

    fetchData() {
      return this.fetchProvider({
        id: this.route.params.id
      }).then(() => {
        this.providerForm = JSON.parse(JSON.stringify(this.providerById(this.route.params.id)));
      }).catch(() => {
        this.$router.push({ path: '/products/providers' });
      });
    },

    renderZone() {
      if (this.providerForm.ward_code) {
        return this.getZoneByWard(this.providerForm.ward_code);
      }

      if (this.providerForm.district_code) {
        return this.getZoneByDistrict(this.providerForm.district_code);
      }

      if (this.providerForm.province_code) {
        return this.getZoneByProvince(this.providerForm.province_code);
      }

      return '';
    },

    logoUrl() {
      return this.providerForm.logo ? this.providerForm.logo.url : dummyImage;
    },

    ...mapActions({
      createProvider: 'providers/create',
      fetchProvider: 'providers/fetchSingle',
      updateProvider: 'providers/update',
      openMediaModal: 'common/openMediaManagerModal'
    })
  },
  watch: {
    route() {
      if (this.route.params.id) {
        this.fetchData();
      } else if (this.$refs.providerForm) {
        this.$refs.providerForm.resetFields();
      }
    },

    selectedLogo() {
      if (this.selectedLogo) {
        this.providerForm.logo = this.selectedLogo;
      }
    }
  },
  created() {
    if (this.route.params.id) {
      this.fetchData();
    } else if (this.$refs.providerForm) {
      this.$refs.providerForm.resetFields();
    }
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

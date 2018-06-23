<template lang="pug">
  div
    el-select.administrative-select(v-model="selectedProvince" @change="filterDistrict" filterable placeholder="Tỉnh/TP")
      el-option(
      v-for="item in provinces"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
    el-select.administrative-select(v-model="selectedDistrict" @change="filterWard" filterable placeholder="Huyện/Thị trấn" :disabled="!selectedProvince")
      el-option(
      v-for="item in districts"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
    el-select(v-model="selectedWard" @change="selectWard" filterable placeholder="Xã/Phường" :disabled="!selectedDistrict")
      el-option(
      v-for="item in wards"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
import originProvinces from './province.json';
import originDistricts from './district.json';
import originWards from './ward.json';

export default {
  name: 'administrative-select',
  model: {
    prop: 'selectedAdministrative',
    event: 'change'
  },
  props: {
    selectedAdministrative: Object
  },
  data() {
    return {
      provinces: JSON.parse(JSON.stringify(originProvinces)),
      districts: {},
      wards: {},
      selectedProvince: '',
      selectedDistrict: '',
      selectedWard: ''
    };
  },
  methods: {
    filterDistrict(provinceCode) {
      const objects = JSON.parse(JSON.stringify(originDistricts));
      this.districts = this._filterObject(objects, provinceCode);
      this.selectedDistrict = '';
      this.selectedWard = '';
      this._sendSelectedObjectToParent();
    },
    filterWard(districtCode) {
      const objects = JSON.parse(JSON.stringify(originWards));
      this.wards = this._filterObject(objects, districtCode);
      this.selectedWard = '';
      this._sendSelectedObjectToParent();
    },
    selectWard(wardCode) {
      this._sendSelectedObjectToParent();
    },
    _filterObject(orginObjects, code) {
      let tempObjects = Object.keys(orginObjects).map((index) => {
        return orginObjects[index];
      });

      tempObjects = tempObjects.filter((item) => {
        return item.parent_code === code;
      }) || [];

      if (tempObjects.length) {
        tempObjects.sort((a, b) => {
          const nameA = a.name_with_type.toUpperCase();
          const nameB = b.name_with_type.toUpperCase();
          if (nameA < nameB) {
            return -1;
          }
          if (nameA > nameB) {
            return 1;
          }

          return 0;
        });
      }

      return tempObjects;
    },
    _sendSelectedObjectToParent() {
      this.$emit('change', {
        selectedProvince: this.selectedProvince,
        selectedDistrict: this.selectedDistrict,
        selectedWard: this.selectedWard
      });
    }
  }
}
</script>

<style lang="scss" scoped>
.administrative-select {
  margin-right: 10px;
}
</style>

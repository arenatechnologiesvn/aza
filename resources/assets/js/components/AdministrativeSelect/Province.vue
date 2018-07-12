<template lang="pug">
  el-select(v-model="selectedProvince" clearable style="width: 100%" filterable placeholder="Tỉnh/TP")
    el-option(
      v-for="item in provinces"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
import originProvinces from './province.json';

export default {
  name: 'province-select',
  model: {
    prop: 'selectedProvince',
    event: 'change'
  },
  props: {
    selectedProvince: String
  },
  data() {
    return {
      provinces: JSON.parse(JSON.stringify(originProvinces))
    };
  },
  methods: {
    // _sendSelectedObjectToParent() {
    //   this.$emit('change', {
    //     selectedProvince: this.selectedProvince,
    //     selectedDistrict: this.selectedDistrict,
    //     selectedWard: this.selectedWard
    //   });
    // }
  }
}
</script>

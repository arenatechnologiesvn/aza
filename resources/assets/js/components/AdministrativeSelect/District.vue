<template lang="pug">
  el-select(v-model="selectedDistrict" clearable style="width: 100%" filterable placeholder="Huyện Quận")
    el-option(
      v-for="item in districts"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
import originDistricts from './district.json';

export default {
  name: 'district-select',
  model: {
    prop: 'selectedDistrict',
    event: 'change'
  },
  props: {
    selectedDistrict: String
  },
  data() {
    return {
      districts: JSON.parse(JSON.stringify(originDistricts))
    };
  },
  methods: {
  }
}
</script>

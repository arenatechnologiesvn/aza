<template lang="pug">
  el-select(v-model="selectedWard" clearable style="width: 100%" filterable placeholder="Xã/Phường")
    el-option(
      v-for="item in wards"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
import originWards from './ward.json';

export default {
  name: 'ward-select',
  model: {
    prop: 'selectedWard',
    event: 'change'
  },
  props: {
    selectedWard: String
  },
  data() {
    return {
      wards: JSON.parse(JSON.stringify(originWards))
    };
  },
  methods: {

  }
}
</script>

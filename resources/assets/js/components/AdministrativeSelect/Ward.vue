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
import { filterObject } from './mixins'

export default {
  name: 'ward-select',
  model: {
    prop: 'ward',
    event: 'change'
  },
  props: {
    ward: String,
    parentCode: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      wards: [],
      selectedWard: ''
    };
  },
  methods: {
    filterWard(parentCode) {
      const objects = JSON.parse(JSON.stringify(originWards));
      this.wards = filterObject(objects, parentCode);
    },

    _sendSelectedObjectToParent() {
      this.$emit('change', this.selectedWard);
    }
  },
  watch: {
    parentCode() {
      if (this.parentCode) {
        this.filterWard(this.parentCode);
      } else {
        this.wards = [];
      }

      this.selectedWard = '';
      this._sendSelectedObjectToParent();
    }
  }
}
</script>

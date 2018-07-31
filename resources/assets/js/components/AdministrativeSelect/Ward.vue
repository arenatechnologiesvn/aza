<template lang="pug">
  el-select(v-model="selectedWard" clearable style="width: 100%" filterable placeholder="Xã/Phường" @change="sendSelectedObjectToParent" :size="size")
    el-option(
      v-for="item in filteredWards"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
/*
* Use: ward-select(v-model="ward_code" :parent-code="district_code")
* Param:
*  - v-model: String
*  - parent-code: String
*/

import { mapGetters } from 'vuex';
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
      required: true,
      validator: (val) => {
        return val === null || typeof val === 'string';
      }
    },
    size: {
      type: String,
      default: () => {
        return 'small';
      }
    }
  },
  computed: {
    ...mapGetters({
      originWards: 'administrative/getWards'
    }),

    filteredWards() {
      return filterObject(this.originWards, this.parentCode);
    }
  },
  data() {
    return {
      selectedWard: ''
    };
  },
  methods: {
    sendSelectedObjectToParent() {
      this.$emit('change', this.selectedWard);
    }
  },
  watch: {
    ward() {
      if (this.selectedWard !== this.ward) {
        this.selectedWard = this.ward;
      }
    },
    parentCode(newVal, oldVal) {
      if (!newVal || (oldVal && newVal !== oldVal)) {
        this.selectedWard = '';
        this.sendSelectedObjectToParent();
      }
    }
  }
}
</script>

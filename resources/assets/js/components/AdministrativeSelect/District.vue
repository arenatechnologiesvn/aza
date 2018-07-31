<template lang="pug">
  el-select(v-model="selectedDistrict" clearable style="width: 100%" filterable placeholder="Huyện/Quận" @change="sendSelectedObjectToParent" :size="size")
    el-option(
      v-for="item in filteredDistricts"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
/*
* Use: district-select(v-model="district_code" :parent-code="province_code")
* Param:
*  - v-model: String
*  - parent-code: String
*/

import { mapGetters } from 'vuex';
import { filterObject } from './mixins'

export default {
  name: 'district-select',
  model: {
    prop: 'district',
    event: 'change'
  },
  props: {
    district: String,
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
      originDistricts: 'administrative/getDistricts'
    }),

    filteredDistricts() {
      return filterObject(this.originDistricts, this.parentCode);
    }
  },
  data() {
    return {
      selectedDistrict: ''
    };
  },
  methods: {
    sendSelectedObjectToParent() {
      this.$emit('change', this.selectedDistrict);
    }
  },
  watch: {
    district() {
      if (this.selectedDistrict !== this.district) {
        this.selectedDistrict = this.district;
      }
    },

    parentCode(newVal, oldVal) {
      if (!newVal || (oldVal && newVal !== oldVal)) {
        this.selectedDistrict = '';
        this.sendSelectedObjectToParent();
      }
    }
  }
}
</script>

<template lang="pug">
  el-select(v-model="selectedProvince" clearable style="width: 100%" filterable placeholder="Tỉnh/TP" @change="_sendSelectedObjectToParent" :size="size")
    el-option(
      v-for="item in provinces"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
/*
* Use: province-select(v-model="province_code")
* Param:
*  - v-model: String
*/

import { mapGetters } from 'vuex';

export default {
  name: 'province-select',
  model: {
    prop: 'province',
    event: 'change'
  },
  props: {
    province: String,
    size: {
      type: String,
      default: () => {
        return 'small';
      }
    }
  },
  computed: {
    ...mapGetters({
      provinces: 'administrative/getProvinces'
    })
  },
  data() {
    return {
      selectedProvince: ''
    };
  },
  methods: {
    _sendSelectedObjectToParent() {
      this.$emit('change', this.selectedProvince);
    }
  },
  watch: {
    province() {
      if (this.selectedProvince !== this.province) {
        this.selectedProvince = this.province
      }
    }
  }
}
</script>

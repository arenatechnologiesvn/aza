<template lang="pug">
  el-select(v-model="selectedProvince" clearable style="width: 100%" filterable placeholder="Tỉnh/TP" @change="_sendSelectedObjectToParent")
    el-option(
      v-for="item in provinces"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'province-select',
  model: {
    prop: 'province',
    event: 'change'
  },
  props: {
    province: String
  },
  computed: {
    ...mapGetters({
      provinces: 'administrative/getProvinces'
    })
  },
  data() {
    return {
      selectedProvince: this.province
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

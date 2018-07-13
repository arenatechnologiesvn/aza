<template lang="pug">
  el-select(v-model="selectedWard" clearable style="width: 100%" filterable placeholder="Xã/Phường" @change="_sendSelectedObjectToParent")
    el-option(
      v-for="item in wards"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
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
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters({
      originWards: 'administrative/getWards'
    })
  },
  data() {
    return {
      wards: [],
      selectedWard: ''
    };
  },
  methods: {
    filterWard(parentCode) {
      const objects = JSON.parse(JSON.stringify(this.originWards));
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
    },

    // ward() {
    //   if (this.selectedWard !== this.ward) {
    //     this.selectedWard = this.ward;
    //   }
    // }
  }
}
</script>

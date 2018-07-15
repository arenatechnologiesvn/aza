<template lang="pug">
  el-select(v-model="selectedDistrict" clearable style="width: 100%" filterable placeholder="Huyện/Quận" @change="_sendSelectedObjectToParent")
    el-option(
      v-for="item in districts"
      :key="item.code"
      :label="item.name_with_type"
      :value="item.code")
</template>

<script>
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
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters({
      originDistricts: 'administrative/getDistricts'
    })
  },
  data() {
    return {
      districts: [],
      selectedDistrict: ''
    };
  },
  methods: {
    filterDistrict(parentCode) {
      const objects = JSON.parse(JSON.stringify(this.originDistricts));
      this.districts = filterObject(objects, parentCode);
    },

    _sendSelectedObjectToParent() {
      this.$emit('change', this.selectedDistrict);
    }
  },
  watch: {
    parentCode() {
      if (this.parentCode) {
        this.filterDistrict(this.parentCode);
      } else {
        this.districts = [];
      }

      this.selectedDistrict = '';
      this._sendSelectedObjectToParent();
    },

    // district() {
    //   if (this.selectedDistrict !== this.district) {
    //     this.selectedDistrict = this.district;
    //   }
    // }
  }
}
</script>

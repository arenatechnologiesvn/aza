import originProvinces from '~/assets/administrative/province.json';
import originDistricts from '~/assets/administrative/district.json';
import originWards from '~/assets/administrative/ward.json';

const POPULAR_PROVINCES = [1, 48, 79];

const convertObject = (orginObjects) => {
  return Object.keys(orginObjects).map((index) => {
    return orginObjects[index];
  });
};

const adminstrative = {
  namespaced: true,

  state: {
    provinces: JSON.parse(JSON.stringify(originProvinces)),
    districts: JSON.parse(JSON.stringify(originDistricts)),
    wards: JSON.parse(JSON.stringify(originWards))
  },

  getters: {
    getProvinces (state) {
      let groups = [{
        label: 'Phổ biến',
        options: []
      }, {
        label: 'Tỉnh/TP',
        options: []
      }];
      convertObject(state.provinces).forEach(province => {
        if (POPULAR_PROVINCES.includes(parseInt(province.code))) {
          groups[0].options.push(province);
        } else {
          groups[1].options.push(province);
        }
      });

      return groups;
    },

    getDistricts (state) {
      return state.districts;
    },

    getWards (state) {
      return state.wards;
    },

    getZoneByProvince: (state) => (code) => {
      const province = convertObject(state.provinces).find(item => {
        return item.code === code;
      });

      return province ? province.name_with_type : '';
    },

    getZoneByDistrict: (state) => (code) => {
      const district = convertObject(state.districts).find(item => {
        return item.code === code;
      });

      return district ? district.path_with_type : '';
    },

    getZoneByWard: (state) => (code) => {
      const ward = convertObject(state.wards).find(item => {
        return item.code === code;
      });

      return ward ? ward.path_with_type : '';
    }
  }
};

export default adminstrative;

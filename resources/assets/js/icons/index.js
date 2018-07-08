import Vue from 'vue';
import common from '~/store/modules/common.js';
import SvgIcon from '~/components/SvgIcon';

// register globally
Vue.component('svg-icon', SvgIcon);

const requireAll = requireContext => requireContext.keys().map(requireContext)
const req = require.context(
  '!svg-sprite-loader?{"symbolId":"[name]"}!./svg',
  false,
  /.svg$/
);
const icons = requireAll(req);
common.setIcons(icons);

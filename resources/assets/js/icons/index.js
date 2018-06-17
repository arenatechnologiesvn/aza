import Vue from 'vue'
import SvgIcon from '~/components/SvgIcon'

// register globally
Vue.component('svg-icon', SvgIcon)

const requireAll = requireContext => requireContext.keys().map(requireContext)
const req = require.context(
	'!svg-sprite-loader?{"symbolId":"[name]"}!./svg',
	false,
	/.svg$/
)
requireAll(req)

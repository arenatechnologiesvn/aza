export default {
  methods: {
    showTitle (item) {
      return ((item.meta && item.meta.title) || item.name)
    },
    showChildren (item) {
      return item.children && item.children.length > 0
    },
    icon (item) {
      return item.meta && item.meta.icon ? item.meta.icon : ''
    }
  }
}

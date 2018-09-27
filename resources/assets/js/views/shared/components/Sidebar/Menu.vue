<template lang="pug">
  el-menu( mode="vertical" :show-timeout="100" :default-active="$router.path" :collapse="collapse"
    background-color="#001C2C"
    text-color="#bfcbd9"
    active-text-color="#409EFF"
  )
    template( v-for="item in menus")
      el-submenu(v-if="item.children && item.children.length > 0" :index="item.name||item.path" :key="item.path")
        template(slot="title")
          svg-icon(:icon-class="item.meta && item.meta.icon ? item.meta.icon : ''")
          span(slot="title") {{item.name}}
        router-link(to='/form' v-for="child in item.children" :key="child.path")
          el-menu-item( :index="item.path+'/'+child.path")
            svg-icon(:icon-class="child.meta && child.meta.icon ? child.meta.icon : ''")
            span(slot="title") {{child.name}}
      router-link(v-else to='/form' :key="item.path")
        el-menu-item(:index="item.name")
          svg-icon(:icon-class="item.meta && item.meta.icon  ? item.meta.icon : '' ")
          span(slot="title") {{item.name}}
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'SidebarItem',
    props: {
      collapse: Boolean
    },
    computed: {
      ...mapGetters([
          'sidebar',
          'permission_routers'
        ]
      ),
      isCollapse() {
        return !this.sidebar.opened
      },
      menus () {
        return this.permission_routers.filter(item => !item.hidden )
      }
    },
    methods: {
      hasOneShowingChildren(children) {
        const showingChildren = children.filter(item => {
          return !item.hidden
        })
        if (showingChildren.length === 1) {
          return true
        }
        return false
      }
    }
  }
</script>

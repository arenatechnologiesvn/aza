<template lang="pug">
  el-menu( mode="vertical" :show-timeout="100" :default-active="$router.path" :collapse="isCollapse"
    background-color="#001C2C"
    text-color="#bfcbd9"
    active-text-color="#409EFF"
  )
    template( v-for="item in menus")
      el-submenu(v-if="item.children && item.children.length > 0" :index="item.name||item.path" :key="item.path")
        template(slot="title")
          i.el-icon-document
          span(slot="title") {{item.name}}
        router-link(to='/form' v-for="child in item.children" :key="child.path")
          el-menu-item( :index="item.path+'/'+child.path")
            i.el-icon-document
            span(slot="title") {{child.name}}
      router-link(v-else to='/form' :key="item.path")
        el-menu-item(:index="item.name")
          i.el-icon-document
          span(slot="title") {{item.name}}
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'SidebarItem',
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
    },
    created () {
      console.log(this.menus)
    }
  }
</script>

<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách nhà cung cấp
    provider-table
</template>

<script>
  import ProviderTable from './components/ProviderTable';

  export default {
    name: 'ProviderIndex',
    components: {
      ProviderTable
    }
  }
</script>

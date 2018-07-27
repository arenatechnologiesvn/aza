export default {
  data () {
    return {
      loader: null,
      selection: {},
      search: {
        key: ''
      }
    };
  },
  methods: {
    loading () {
      this.loader = this.$loading({
        lock: true,
        text: 'Đang tải...',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
    },
    confirm (ok, cancel) {
      this.$confirm('Bạn muốn xóa quyền này?', 'Xác nhận xóa', {
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy bỏ',
        type: 'warning',
        confirmButtonClass: 'el-button el-button--danger'
      }).then(ok).catch(cancel);
    }
  },
  watch: {
    current: function (value) {
      (value && this.loader) && this.loader.close();
    },
    isLoading: function (value) {
      if (value) {
        this.loading();
      } else {
        this.loader && this.loader.close();
      }
    }
  }
};

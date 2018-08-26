<template lang="pug">
  el-dialog(title="Giờ giao hàng"
    :visible.sync="show"
  width="30%"
  center
  @close="onOpened")
    el-form(:model="formTime" ref="form" :rules="rules")
      el-form-item(label="Giờ bắt đầu" prop="start")
        el-select(style="width: 100%;" v-model="formTime.start" placeholder="Giờ bắt đầu giao hàng")
          el-option(v-for="item in 23" :key="item" :label="`${item}h`" :value="`${item}h`")
      el-form-item(label="Giờ kết thúc" prop="end")
        el-select(style="width: 100%;" v-model="formTime.end" placeholder="Giờ kết thúc giao hàng")
          el-option(v-for="item in 23" :key="item" :label="`${item}h`" :value="`${item}h`")
    span(slot="footer")
      el-button(@click="show = false") Hủy
      el-button(type="primary" @click="add") {{buttonTitle}}
</template>

<script>
  export default {
    name: 'ModalTime',
    data () {
      const validateTimeStart = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Thời gian không được trống'));
        } else if (this.formTime.end && parseInt(value) > parseInt(this.formTime.end)) {
          callback(new Error('Thời Gian bắt đầu không được lớn hơn thời gian kết thúc'));
        } else {
          callback();
        }
      };
      const validateTimeEnd = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Thời gian không được trống'));
        } else if (this.formTime.start && parseInt(value) < parseInt(this.formTime.start)) {
          callback(new Error('Thời Gian kết thúc không được nhỏ hơn thời gian bắt đầu'));
        } else {
          callback();
        }
      };
      return {
        show: false,
        isEdit: false,
        buttonTitle: 'Thêm mới',
        rules: {
          start: [
            {required: true, message: 'Thời gian bắt đầu là bắt buộc'},
            { validator: validateTimeStart, trigger: 'blur' }
          ],
          end: [
            {required: true, message: 'Thời gian kết thúc là bắt buộc'},
            { validator: validateTimeEnd, trigger: 'blur' }
          ],
        },
        formTime: {
          start: '',
          end: ''
        },
        steps: {
          start: '00:00',
          step: '01:00',
          end: '23:00'
        }
      }
    },
    methods: {
      add () {
        const time = {start: this.formTime.start, end: this.formTime.end }
        this.$refs['form'].validate(valid => {
          if(valid) {
            this.show = false
            if(this.isEdit) {
              return this.$emit('edit', time)
            } else {
              return this.$emit('add', time)
            }
          }
          return false;
        })

      },
      mshow () {
        this.show = true
      },
      onOpened () {
        this.$refs['form'] && this.$refs['form'].resetFields()
      },
      setData (data) {
        this.formTime = data
      }
    }
  }
</script>

<style scoped>

</style>
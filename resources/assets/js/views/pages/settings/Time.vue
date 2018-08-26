<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid desktop")
        span Cài đặt giờ đặt hàng
      div
        el-form(:model="apply" status-icon :rules="rules" ref="apply")
          el-form-item(label="Giờ bắt đầu" prop="start")
            el-time-select(:picker-options="steps" style="width: 100%;" v-model="apply.start" placeholder="Giờ bắt đàu đặt hàng")
          el-form-item(label="Giờ kết thúc" prop="end")
            el-time-select(:picker-options="steps" style="width: 100%;" v-model="apply.end" placeholder="Giờ kết thúc đặt hàng")
          el-form-item
            el-button(type="primary" @click="save") Lưu thông tin
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid desktop")
        span Cài đặt khung giờ
      div
        modal-time(ref="showTime" @add="onAdd" :time="timeModal")
        div(style="text-align: right;")
          el-table(:data="timeFrame"
          style="width: 100%"
          size="mini"
          border)
            el-table-column(type="index" label="STT" width="60")
            el-table-column(prop="start" label="Giờ bắt đầu")
            el-table-column(prop="end" label="Giờ kết thúc")
            el-table-column(label="#" width="230")
              template(slot-scope="scope")
                el-button(type="warning" @click="edit(scope.row)" size="mini")
                  svg-icon(icon-class="fa-solid user-edit")
                  span Cập nhât
                el-button(type="danger" size="mini" @click="onDelete(scope.row)")
                  svg-icon(icon-class="fa-solid trash")
                  span Xóa bỏ
            div(slot="append" style="padding: 10px; text-align: left;")
              el-button(@click="add" size="mini")
                svg-icon(icon-class="fa-solid plus-circle")
                span Thêm mới
          div(style="margin-top: 10px;")
            el-button(type="primary" @click="saveTimeFrame" size="small")
              svg-icon(icon-class="fa-solid save")
              span Lưu thông tin
</template>

<script>
  import { get, update } from '~/api/setting'
  import ModalTime from './Modal'
  export default {
    name: 'TimeSetting',
    components: {
      ModalTime
    },
    props: {
      steps: {
        type: Object,
        default: () => ({
          start: '00:00',
          step: '00:15',
          end: '23:59'
        })
      }
    },
    data () {
      const validateTimeStart = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Thời gian không được trống'));
        } else if (this.apply.end && value > this.apply.end) {
          callback(new Error('Thời Gian bắt đầu không được lớn hơn thời gian kết thúc'));
        } else {
          callback();
        }
      };
      const validateTimeEnd = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Thời gian không được trống'));
        } else if (this.apply.start && value < this.apply.start) {
          callback(new Error('Thời Gian kết thúc không được nhỏ hơn thời gian bắt đầu'));
        } else {
          callback();
        }
      };
      return {
        apply: {
          start: '',
          end: ''
        },
        times: [
          '7h-9h'
        ],
        rules: {
          start: [
            { validator: validateTimeStart, trigger: 'blur' }
          ],
          end: [
            { validator: validateTimeEnd, trigger: 'blur' }
          ],
        },
        timeFrame: [],
        timeModal: {
          start: '',
          end: ''
        }
      }
    },
    methods: {
      onAdd (data) {
        this.timeFrame = [...this.timeFrame, data]
      },
      add () {
        this.timeModal.start = ''
        this.timeModal.end = ''
        this.$refs['showTime'].mshow()
      },
      onDelete (data) {
        const findIndex = this.timeFrame.findIndex(item => item.start === data.start && item.end === data.end )
        this.timeFrame.splice(findIndex,1)
      },
      edit (data) {
        this.timeModal.start = data.start
        this.timeModal.end = data.end
        this.$refs['showTime'].mshow()
      },
      save () {
        this.$refs['apply'].validate(valid => {
          if(valid) {
            return update('apply', {apply: this.apply}).then(res=> this.apply = res.data.value )
              .then(() => this.$notify(
                {
                  title: 'Thông báo',
                  message: 'Đã cập nhật thành công thông tin',
                  type: 'success'
                }))
              .then(() =>  this.$refs['apply'].clearValidate())
          }
          return false;
        })
      },
      saveTimeFrame () {
        update('timeFrame', {timeFrame: this.timeFrame}).then(res=> this.timeFrame = res.data.value )
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      }
    },
    created () {
      get('apply').then(res => {
        (res.data) && (this.apply = res.data.value)
      } )
      get('timeFrame').then(res => {
        (res.data) && (this.timeFrame = res.data.value)
      } )

    }
  }
</script>

<style lang="scss" scoped>
  svg {
    margin-right: 10px;
  }
</style>
<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid clock")
        span Cài đặt khung giờ đặt hàng
      div
        el-form(:model="apply" status-icon :rules="rules" ref="apply" label-width="120px" size="small")
          el-form-item(label="Giờ bắt đầu" prop="start")
            el-time-select(:picker-options="steps" v-model="apply.start" placeholder="Giờ bắt đàu đặt hàng" style="margin-right: 5px")
            el-tag(type="success") Hôm nay
          el-form-item(label="Giờ kết thúc" prop="end")
            el-time-select(:picker-options="steps" v-model="apply.end" placeholder="Giờ kết thúc đặt hàng" style="margin-right: 5px")
            el-tag(:type="endTimeType()") {{ endTimeTypeLabel() }}
          el-form-item(style="margin-top: 10px")
            el-button(type="primary" @click="save")
              svg-icon(icon-class="fa-solid save")
              span Lưu thông tin
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid truck")
        span Cài đặt khung giờ giao hàng
      div
        modal-time(ref="showTime" @add="onAdd" @edit="onEdit")
        div(style="text-align: right;")
          el-table(:data="timeFrame"
          style="width: 100%"
          size="mini"
          border)
            el-table-column(type="index" label="STT" width="60" align="center")
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
              el-button(type="success" @click="add" size="mini")
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
  import moment from 'moment'

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
        if (this.apply.end && value === this.apply.end) {
          callback(new Error('Thời gian bắt đầu không được trùng thời gian kết thúc'));
        } else {
          callback();
        }
      };
      const validateTimeEnd = (rule, value, callback) => {
        if (this.apply.start && value === this.apply.start) {
          callback(new Error('Thời gian kết thúc không được trùng thời gian bắt đầu'));
        } else {
          callback();
        }
      };
      return {
        apply: {
          start: '',
          end: '',
          is_end_in_today: false
        },
        times: [
          '7h-9h'
        ],
        rules: {
          start: [
            { required: true, message: 'Thời gian bắt đầu không được trống', trigger: 'blur' },
            { validator: validateTimeStart, trigger: 'blur' }
          ],
          end: [
            { required: true, message: 'Thời gian kết thúc không được trống', trigger: 'blur' },
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
        this.$refs['showTime'].formTime.start = ''
        this.$refs['showTime'].formTime.end = ''
        this.$refs['showTime'].isEdit = false
        this.$refs['showTime'].buttonTitle = 'Thêm mới'
        this.timeModal = null
        this.$refs['showTime'].mshow()
      },
      onEdit (data) {
        if(this.timeModal != null) {
          const findIndex = this.timeFrame.findIndex(item => item.start === this.timeModal.start && item.end === this.timeModal.end )
          if(findIndex > -1) {
            this.timeFrame[findIndex].start = data.start
            this.timeFrame[findIndex].end = data.end
          }
        }
      },
      onDelete (data) {
        const findIndex = this.timeFrame.findIndex(item => item.start === data.start && item.end === data.end )
        this.timeFrame.splice(findIndex,1)
      },
      edit (data) {
        this.$refs['showTime'].formTime.start = data.start
        this.$refs['showTime'].formTime.end = data.end
        this.$refs['showTime'].isEdit = true
        this.$refs['showTime'].buttonTitle = 'Cập nhật'
        this.timeModal = data
        this.$refs['showTime'].mshow()
      },
      save () {
        this.$refs['apply'].validate(valid => {
          if(valid) {
            this.apply.is_end_in_today = this.isEndTimeInToday();
            return update('apply', { apply: this.apply }).then(res=> this.apply = res.data.value )
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
      },
      endTimeType() {
        if (this.isEndTimeInToday()) return 'success';
        return 'danger';
      },
      endTimeTypeLabel() {
        if (this.isEndTimeInToday()) return 'Hôm nay';
        return 'Ngày mai';
      },
      isEndTimeInToday() {
        const startTime = moment(this.apply.start, 'hh:mm');
        var endTime = moment(this.apply.end, 'hh:mm');
        return startTime.isBefore(endTime);
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
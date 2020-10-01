import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  FlatList,
  ScrollView
} from 'react-native';
import _ from 'lodash';
import moment from 'moment';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome'
import { faSortDown, faBullseye, faTimes, faCheck, faCalendarAlt } from '@fortawesome/free-solid-svg-icons';
import { faCircle, faTimesCircle } from '@fortawesome/free-regular-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext, SET_TIMES } from '../../store/store'
import { DebugInstructions } from 'react-native/Libraries/NewAppScreen';

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    const params = props.route.params
    var disabledTimes = [], reservedTimes = [], limits = 1

    if (params.isSubsc) {
      limits = params.limits

      params.subscItems.map(subItems => {
        subItems.map(item => {
          if (item.reserve_time) {
            if (item.pack_item_id == params.pack_id) reservedTimes.push( moment(item.reserve_time, 'YYYY-MM-DD HH:mm') )
            else disabledTimes.push( moment(item.reserve_time, 'YYYY-MM-DD HH:mm') )
          }
        })
      })
    }

    const {trade_id, item_id} = params
    this.state = {
      loading: true,
      token: context.state.token,
      trade_id,
      item_id,
      limits: limits,

      isSubsc: params.isSubsc,

      currentWeek: moment(),
      modalVisible: false,
      days: [],
      reservedTimes: reservedTimes,
      disabledTimes: disabledTimes,
      forbidTimes: [],

      holidays: [],
      startDuration: 0,
      endDuration: 0,
      interval: 0,
      treatTime: 0,
      hours: []
    };
  }
  async componentDidMount() {
    const {trade_id, token, item_id} = this.state

    const responseForbid = await Api.get_forbid_reservation_time(token, trade_id, item_id)
    var forbidTimes = []
    responseForbid.data.map(d => forbidTimes.push([
        moment.utc(d.start_time, 'YYYY-MM-DD HH:mm'),
        moment.utc(d.end_time, 'YYYY-MM-DD HH:mm'),
      ])
    )
    
    const response = await Api.get_reservation_basic_info(trade_id, item_id)
    if (response.code == 1) {
      const {data} = response
      // console.log(forbidTimes)
      // console.log(data)
      this.resetWeekDays(this.state.currentWeek, data, forbidTimes)
    }
  }
  onBack = () => {
    const times = this.state.reservedTimes.map(time => time.format('YYYY-MM-DD HH:mm'))
    this.context.dispatch({type: SET_TIMES, times: times})
    setTimeout(() => {
      this.props.route.params.onBack()
      this.props.navigation.goBack()
    }, 100)
  }
  getMinDuration = (times, interval) => {
    var min = 99999
    times.map(time => min = Math.min(min, moment.duration(time).asMinutes()))
    return min / interval
  }
  getMaxDuration = (times, interval) => {
    var max = 0
    times.map(time => max = Math.max(max, moment.duration(time).asMinutes()))
    return max / interval
  }
  resetWeekDays = (date, data = null, forbidTimes = null) => {
    var weekStart = date.day(date.day() >= 1 ? 1 :-6)
    if (data) {
      // const diff = moment.utc(moment(data[1].recept_ed_time, "HH:mm").diff(moment(data[1].recept_st_time, "HH:mm"))).format("HH:mm")
      const interval = data[2]
      const treatTime = data[4]
      const startDuration = this.getMinDuration([
        data[1].recept_st_time,
        data[3].mon_st_hours,
        data[3].tue_st_hours,
        data[3].wed_st_hours,
        data[3].thu_st_hours,
        data[3].fri_st_hours,
        data[3].sat_st_hours,
        data[3].sun_st_hours,
      ], interval)
      const endDuration = this.getMaxDuration([
        data[1].recept_ed_time,
        data[3].mon_ed_hours,
        data[3].tue_ed_hours,
        data[3].wed_ed_hours,
        data[3].thu_ed_hours,
        data[3].fri_ed_hours,
        data[3].sat_ed_hours,
        data[3].sun_ed_hours,
      ], interval)

      this.setState({
        holidays: data[0],
        interval,
        treatTime,
        startDuration,
        endDuration,
        receptHours: [
          data[1].recept_st_time,
          data[1].recept_ed_time
        ],
        hours: [
          [data[3].mon_st_hours, data[3].mon_ed_hours],
          [data[3].tue_st_hours, data[3].tue_ed_hours],
          [data[3].wed_st_hours, data[3].wed_ed_hours],
          [data[3].thu_st_hours, data[3].thu_ed_hours],
          [data[3].fri_st_hours, data[3].fri_ed_hours],
          [data[3].sat_st_hours, data[3].sat_ed_hours],
          [data[3].sun_st_hours, data[3].sun_ed_hours],
        ],
        loading: false,
        currentWeek: date,
        days: _.range(0, 7).map(d => moment(weekStart).add(d, 'days')),
        forbidTimes
      })
    } else {
      this.setState({
        currentWeek: date,
        days: _.range(0, 7).map(d => moment(weekStart).add(d, 'days'))
      })
    }
  }
  previousWeek = () => {
    const now = this.state.currentWeek.clone()
    this.resetWeekDays(now.add(-7, 'days'))
  }
  nextWeek = () => {
    const now = this.state.currentWeek.clone()
    const newWeek = now.add(7, 'days')

    if( moment().add(6, 'weeks').isBefore(newWeek) ) return

    this.resetWeekDays(newWeek)
  }
  renderWeekDay = (date, index) => {
    let weekday = date.day();
    let day = date.date();
    let weekdays = ['日', '月', '火', '水', '木', '金', '土']
    let {dayLabel, weekdayItemContainer, weekdayLabel} = styles

    if (weekday == 6) {
      weekdayItemContainer = {
        ...weekdayItemContainer,
        backgroundColor: colors.skyColor
      }
      weekdayLabel = {
        ...weekdayLabel,
        color: colors.blueColor
      }
      dayLabel = {
        ...weekdayLabel,
        color: colors.blueColor,
        fontSize: dimen(4)
      }
    } else if (weekday == 0) {
      weekdayItemContainer = {
        ...weekdayItemContainer,
        backgroundColor: colors.lightPinkColor
      }
      weekdayLabel = {
        ...weekdayLabel,
        color: colors.red2Color
      }
      dayLabel = {
        ...weekdayLabel,
        color: colors.red2Color,
        fontSize: dimen(4)
      }
    }
    return (
      <View key={index} style={weekdayItemContainer}>
        <Text style={dayLabel}>{ `${day}` }</Text>
        <Text style={weekdayLabel}>{ `（${weekdays[weekday]}）` }</Text>
      </View>
    )
  }
  pad = (num, size = 2) => ('000' + num).slice(size * -1)
  reserveTime = (day, timeIndex, flag = true) => () => {
    const {reservedTimes, limits, interval} = this.state
    const hours = Math.floor(timeIndex / (60 / interval))
    const minutes = (timeIndex * interval) % 60
    let str = `${day.format("YYYY-MM-DD")} ${this.pad(hours)}:${this.pad(minutes)}`;
    let time = moment(str, "YYYY-MM-DD HH:mm");

    if (flag) {
      if (reservedTimes.length >= limits) return

      this.setState({
        reservedTimes: [...reservedTimes, time]
      })
    } else {
      const newTimes = [...reservedTimes]
      _.remove(newTimes, time)
      this.setState({ reservedTimes: newTimes })
    }
  }
  removeTime = (i) => () => {
    const {reservedTimes, limits} = this.state
    const newTimes = [...reservedTimes]
    _.remove(newTimes, reservedTimes[i])
    this.setState({ reservedTimes: newTimes })
  }
  timeDisabled = (day, timeIndex, weekdays) => {
    const {interval, holidays, hours, treatTime, receptHours} = this.state
    let hour = Math.floor(timeIndex / (60 / interval))
    let minute = (timeIndex * interval) % 60

    if (moment().isSame(day, 'day')) {
      if (moment().hour() == hour)
        if (moment().minute() >= minute)
          return true
      if (moment().hour() > hour) return true
    }
    if (moment().isAfter(day, 'day')) return true

    const realIndex = weekdays == 6 ? 0 : weekdays + 1
    if (holidays[realIndex] == '1') return true

    const time = timeIndex * interval

    const recept_st = moment.duration(receptHours[0]).asMinutes()
    const recept_ed = moment.duration(receptHours[1]).asMinutes()
    const day_st = moment.duration(hours[weekdays][0]).asMinutes()
    const day_ed = moment.duration(hours[weekdays][1]).asMinutes()
    
    const st = Math.max(recept_st, day_st)
    const ed = Math.min(day_ed - treatTime, recept_ed)
    if (time > ed || time < st) return true
    return this.timeForbids(day, timeIndex, weekdays)
  }
  timeReserved = (day, timeIndex) => {
    const {interval} = this.state
    let hour = Math.floor(timeIndex / (60 / interval))
    let minute = (timeIndex * interval) % 60
    for (let i = 0; i < this.state.reservedTimes.length; i ++) {
      let time = this.state.reservedTimes[i];
      if (day.isSame(time, 'day') && time.hour() == hour && time.minute() == minute) {
        return true
      }
    }
    return false
  }
  timeOthers = (day, timeIndex) => {
    const {interval} = this.state
    let hour = Math.floor(timeIndex / (60 / interval))
    let minute = (timeIndex * interval) % 60
    for (let i = 0; i < this.state.disabledTimes.length; i ++) {
      let time = this.state.disabledTimes[i];
      if (day.isSame(time, 'day') && time.hour() == hour && time.minute() == minute) {
        return true
      }
    }
    return false
  }
  timeForbids = (day, timeIndex, weekdays) => {
    const {interval, treatTime} = this.state
    let hour = Math.floor(timeIndex / (60 / interval))
    let minute = (timeIndex * interval) % 60
    const date = day.hours(hour).minutes(minute)
    const dateS = date.format('YYYY-MM-DD HH:mm')
    const dateE = date.format('YYYY-MM-DD HH:mm')
    
    for (let i = 0; i < this.state.forbidTimes.length; i ++) {
      let timeS = this.state.forbidTimes[i][0];
      let timeE = this.state.forbidTimes[i][1];
      if(moment.utc(dateS).isAfter(moment.utc(timeS).add(-treatTime + 1, 'minutes')) && moment.utc(dateE).isBefore(moment.utc(timeE))) {
        return true
      }
    }
    return false
  }
  renderLine = ({item}) => {
    const {interval} = this.state
    let hour = Math.floor(item / (60 / interval))
    let minute = (item * interval) % 60
    return (
      <View key={item} style={styles.tableWrapper}>
        <Text style={styles.timeLabel}>{ `${this.pad(hour, 2)} : ${this.pad(minute, 2)}` }</Text>
        <View style={styles.timeLineContainer}>
        {
          this.state.days.map((day, index) => {
            if (this.timeDisabled(day, item, index)) {
              return (
                <View key={index} style={{...styles.timeLineItem, backgroundColor: colors.gray230}}>
                  <FontAwesomeIcon icon={ faTimes } color={ colors.gray160 } />
                </View>
              )  
            } else if (this.timeReserved(day, item)) {
              return (
                <TouchableOpacity key={index} style={{...styles.timeLineItem, backgroundColor: colors.primaryColor }}
                  onPress={this.reserveTime(day, item, false)}
                >
                  <FontAwesomeIcon icon={ faCheck } color={ colors.whiteColor } />
                </TouchableOpacity>
              )
            } else if (this.timeOthers(day, item)) {
              return (
                <View key={index} style={{...styles.timeLineItem, backgroundColor: colors.gray230  }}
                  onPress={this.reserveTime(day, item, false)}
                >
                  <FontAwesomeIcon icon={ faCheck } color={ colors.whiteColor } />
                </View>
              )
            } else {
              return (
                <View key={index} style={styles.timeLineItem}>
                  <TouchableOpacity onPress={this.reserveTime(day, item)} style={styles.timeLineItemTouchable}>
                    <FontAwesomeIcon icon={ faCircle } color={ colors.faOrange } />
                  </TouchableOpacity>
                </View>
              )
            }
          })
        }
        </View>
      </View>
    )
  }
  renderBtnContainer = () => {
    return (
      <View style={styles.btnContainer}>
        <TouchableOpacity onPress={this.previousWeek}>
          <Text style={styles.text}>前の週</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={this.nextWeek}>
          <Text style={styles.text}>次の週</Text>
        </TouchableOpacity>
      </View>
    )
  }
  renderCalendarHeader = () => {
    let self = this
    const {currentWeek} = this.state
    return (
      <View style={[styles.tableWrapper, {borderBottomColor: colors.gray230, borderBottomWidth: 0.3}]}>
        <Text style={styles.timeTitleLabel}>日時</Text>
        <View style={styles.time_header}>
          <Text style={styles.monthLabel}>{ currentWeek.format('YYYY年MM月') }</Text>
          <View style={styles.weekdayContainer}>
          {
            this.state.days.map((day, index) => {
              return self.renderWeekDay(day, index)
            })
          }
          </View>
        </View>
      </View>
    )
  }
  renderCalendarBody = () => {
    const {startDuration, endDuration} = this.state

    return (
      <FlatList
        data={_.range(startDuration, endDuration)}
        renderItem={this.renderLine}
        keyExtractor={item => item.toString()}
        showsVerticalScrollIndicator={false}
      />
    )
  }

  render() {
    const {
      loading, isSubsc, reservedTimes, disabledTimes, limits, hours,
      treatTime, interval
    } = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title='予約の時間'
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />
        {loading && <Indicator/> }
        {!loading &&
          <>
            <View style={{backgroundColor: '#F6F6F6'}}>
              <Text style={styles.txt_tag}>予約管理からいつでも予約を変更追加することが出来ます。</Text>
            </View>
            { this.renderBtnContainer() }
            <View style={styles.calendarContainer}>
              { this.renderCalendarHeader() }
              { this.renderCalendarBody() }
            </View>

            <View style={{marginVertical: dimen(1)}}>
              {isSubsc &&
              <View style={styles.times}>
                <ScrollView horizontal={true}>
                  {[...Array(limits)].map((e, i) => {
                    if (i < reservedTimes.length) {
                      return (
                        <TouchableOpacity key={i} style={styles.titem_enable}
                          onPress={this.removeTime(i)}
                        >
                          <Text style={styles.titem_enable_txt}>{reservedTimes[i].format('M月D日H:mm〜')}</Text>
                          <FontAwesomeIcon icon={ faTimesCircle } color='gray' />
                        </TouchableOpacity>
                      )
                    } else {
                      return (
                        <View key={i} style={styles.titem_enable}>
                          <Text style={styles.titem_enable_txt}>あと{limits - i}回予約可能</Text>
                        </View>
                      )
                    }
                  })}
                  {disabledTimes.map((time, i) => {
                    return (
                      <View key={i} style={styles.titem_disable}>
                        <Text style={styles.titem_disable_txt}>{time.format('M月D日H:mm〜')}</Text>
                        <FontAwesomeIcon icon={ faTimesCircle } color='white' />
                      </View>
                    )
                  })}
                </ScrollView>
              </View>
              }
            </View>
            
            <Text style={styles.txt_menu}>
              {`予約開始時間を選択してください。${"\n"}このメニューの所要時間は${treatTime ?? interval}分です。`}
            </Text>

            <TouchableOpacity style={styles.reserveBtn}
              onPress={this.onBack}
            >
              <Text style={styles.reserveBtnTitle}>確定する</Text>
            </TouchableOpacity>
          </>
        }
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'white',
  },
  txt_tag: {
    fontSize: dimen(3),
    color: colors.textColor,
    margin: dimen(2),
    borderWidth: 0.7,
    borderColor: 'lightgray',
    backgroundColor: 'white',
    lineHeight: dimen(6),
    paddingLeft: dimen(2)
  },
  dateIcon: {
    width: dimen(5.2),
    height: dimen(5.2),
    resizeMode: "contain",
  },
  text: {
    fontSize: dimen(4),
    textAlign: 'center',
    color: colors.blackColor
  },
  dateTitle: {
    fontSize: dimen(4.5),
    textAlign: 'center',
    color: colors.gray128,
    marginLeft: dimen(1)
  },
  dateArea: {
    flex: 1,
    flexDirection: 'row',
    height: dimen(7),
    alignItems: 'center'
  },
  dateLabel: {
    flex: 1,
    fontSize: dimen(5.5),
    marginRight: dimen(5),
    textAlign: 'center',
    color: colors.blackColor,
    marginLeft: dimen(1)
  },
  divider: {
    width: 1,
    height: dimen(5),
    backgroundColor: colors.gray204,
    marginLeft: dimen(5),
    marginRight: dimen(5)
  },
  topMonthContainer: {
    flexDirection: 'row',
    marginTop: 10,
    alignItems: 'center',
    marginLeft: dimen(3),
    marginRight: dimen(3)
  },
  btnContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginVertical: dimen(2),
    marginLeft: dimen(3),
    marginRight: dimen(3)
  },
  calendarContainer: {
    flex: 1,
    borderWidth: 1,
    borderColor: colors.gray230,
    marginLeft: dimen(2),
    marginRight: dimen(2)
  },
  timeTitleLabel: {
    width: dimen(15),
    fontSize: dimen(3.5),
    textAlign: 'center',
    color: colors.gray160,
  },
  time_header: {
    flex: 1,
    borderLeftWidth: 0.5,
    borderLeftColor: colors.gray230
  },
  timeLabel: {
    width: dimen(15),
    fontSize: dimen(3.5),
    textAlign: 'center',
    color: colors.blackColor,
  },
  weekdayLabel: {
    fontSize: dimen(3),
    textAlign: 'center',
    color: colors.gray160
  },
  dayLabel: {
    fontSize: dimen(4),
    textAlign: 'center',
    color: colors.brownColor
  },
  tableWrapper: {
    flexDirection: 'row',
    alignItems: 'center',
    borderTopColor: colors.gray230,
    borderTopWidth: 0.5,
  },
  monthLabel: {
    fontSize: dimen(3),
    textAlign: 'center',
    alignSelf: 'stretch',
    color: colors.lightBrownColor,
    paddingVertical: dimen(1)
  },
  weekdayContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-around',
    borderTopColor: colors.gray230,
    borderTopWidth: 0.5
  },
  weekdayItemContainer: {
    width: dimen(81 / 7),
    height: dimen(81 / 7),
    justifyContent: 'center',
    borderRightWidth: 0.5,
    borderRightColor: colors.gray230
  },
  timeLineContainer: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-around',
  },
  timeLineItem: {
    height: dimen(8),
    width: dimen(81 / 7),
    borderLeftColor: colors.gray230,
    borderLeftWidth: 0.5,
    alignItems: 'center',
    justifyContent: 'center'
  },
  timeLineItemTouchable: {
    width: '100%',
    height: '100%',
    alignItems: 'center',
    justifyContent: 'center'
  },
  reserveBtn: {
    margin: dimen(4),
    marginTop: 0,
    backgroundColor: colors.primaryColor,
    textAlign: "center",
    borderRadius: dimen(6),
    overflow: "hidden",
  },
  reserveBtnTitle: {
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(12),
    fontSize: dimen(6)
  },
  times: {
    marginVertical: dimen(1.5),
    height: 40,
    padding: 5,
  },
  titem_disable: {
    flexDirection: 'row',
    borderRadius: 20,
    backgroundColor: 'gray',
    alignItems: 'center',
    paddingHorizontal: 5,
    marginRight: 5
  },
  titem_disable_txt: {
    color: 'white'
  },
  titem_enable: {
    flexDirection: 'row',
    borderRadius: 20,
    alignItems: 'center',
    paddingHorizontal: 5,
    marginRight: 5,
    borderWidth: 0.5,
    borderColor: 'gray'
  },
  titem_enable_txt: {
    color: 'gray'
  },
  txt_menu: {
    color: colors.textRed,
    marginLeft: dimen(2),
    fontSize: dimen(3.5),
    lineHeight: dimen(4),
    marginBottom: dimen(1)
  }
});

import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
  Alert
} from 'react-native';
import _ from 'lodash';
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faMapMarkerAlt, faSyncAlt } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ModalCancel from './modalCancel'

import {ERR_DURATION, ERR_MSG} from '../../config/constant'
import { dimen } from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext, SET_TIMES } from '../../store/store'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    const {token, trade_id} = context.state
    const {isSubsc} = props.route.params

    this.state = {
      loading: true,
      token: token,
      trade_id: trade_id,
      isSubsc: isSubsc,
      finished: false,

      reservation: null,
      modalCancel: false,
      reservationSubsc: null,
      polling_ids: [],
      reservation_times: [],
      items: [],
      qrs: [],
      pay_token: null
    };

    this.onCancel = this.onCancel.bind(this)
  }

  componentDidMount() {
    // this.props.navigation.push("ReviewStep", {trade_id: this.state.trade_id})

    this.api_use_reservation()
  }

  componentWillUnmount() {
    clearInterval(this.api_interval);
  }

  onRefresh = () => {
    this.setState({loading: true})
    this.api_use_reservation()
  }

  api_use_reservation = async () => {
    const {token, trade_id, isSubsc} = this.state
    const params = this.props.route.params

    if (!isSubsc) {
      const response = await Api.use_reservation_page(token, trade_id)
      if (response.code != 1) {
        Alert.alert(
          'エラー',
          '',
          [
            {
              text: '確認',
              onPress: () => {
                this.props.navigation.goBack()
              }
            },
          ],
          { cancelable: false }
        );
        return
      }
      const pollingId = response.data.polling_id

      this.setState({
        loading: false,
        pay_token: response.data.pay_token,
        pollingId: pollingId,
        reservation: response.data,
        modalCancel: params ? params.cancelable : false
      })
      
      this.api_interal_(pollingId)
      this.api_interval = setInterval(() => {
        this.api_interal_(this.state.pollingId)
      }, 3000);
    } else {
      const response = await Api.use_reservation_subsc_page(token, trade_id)
      if (response.code == 1) {
        this.setState({loading: false,
          reservation: response.data,
          reservationSubsc: response.data,
          polling_ids: response.data.polling_ids,
          reservation_times: response.data.reservation_times,
          items: response.data.items,
          qrs: response.data.qrs.map(d => d.qr ),
          modalCancel: params ? params.cancelable : false
        })
      } else {
        Alert.alert(ERR_MSG)
      }
    }
  }

  api_interal_ = (pollingId) => {
    const formData = new FormData();
    formData.append('polling_id', pollingId);
    
    const that = this
    Api.axios.post(Api.BASE_URL + 'polling', formData)
      .then(function (response) {
        // console.log("POLLING RESULT NOT SUBSC", response.data, pollingId)
        const code = response.data.code
        if (code == 1) {
          clearInterval(that.api_interval);
          // that.props.navigation.push("OrderEndStep", {trade_id: trade_id})
          that.setState({finished: true})
        }
      })
      .catch(function (error) {
        // console.log("ERROR POLLING NOT SUBSC", error);
      })
  }

  async api_cancel_reserve() {
    const {token, trade_id} = this.state
    const response = await Api.cancel_reservation(token, trade_id)
    if (response.code == 1) {
      this.setState({loading: false, modalCancel: true})
    } else if (response.code == -2) {
      Alert.alert('予約時間の2時間前を過ぎているためキャンセルできません。', '',
        [{
          text: 'はい',
          onPress: () => this.setState({loading: false})
        }]
      )
    } else {
      this.setState({loading: false})
    }
  }
  async api_cancel_reservation_subsc(index) {
    const {token, trade_id, reservationSubsc,
      polling_ids, items, reservation_times, qrs
    } = this.state
    const response = await Api.cancel_reservation_subsc(token, trade_id, this.state.polling_ids[index])

    if (response.code == 1) {
      var nPolling_ids = polling_ids.filter(d => d != polling_ids[index])
      var nReservation_times = reservation_times.filter(d => d != reservation_times[index])
      var nItems = items.filter(d => d != items[index])
      var nQrs = qrs.filter(d => d != qrs[index])

      this.setState({polling_ids: nPolling_ids, reservation_times: nReservation_times, items: nItems, qrs: nQrs, loading: false})
    } else if (response.code == -2) {
      Alert.alert('予約時間の2時間前を過ぎているためキャンセルできません。', '',
        [{
          text: 'はい',
          onPress: () => this.setState({loading: false})
        }]
      )
    } else {
      this.setState({loading: false})
    }
  }

  onFinish = () => {
    clearInterval(this.api_interval);
    this.props.navigation.navigate("TabHistory", {initial: 'RTabUse'})
  }

  async onCancel(index, finished) {
    clearInterval(this.api_interval);

    if (finished) {
      const {trade_id} = this.state
      this.props.navigation.push("ReviewStep", {trade_id: trade_id})
    } else {
      if (index != null) {
        this.setState({loading: true})
        await this.api_cancel_reservation_subsc(index)
      } else {
        await this.api_cancel_reserve()
      }
    }
  }

  onCancelConfirm = () => {
    const {token, trade_id} = this.state
    this.setState({modalCancel: false})
    this.context.dispatch({type: SET_TIMES, times: []})
    Api.cancel_reservation_page(token, trade_id)
    this.props.navigation.goBack()
  }
  
  render() {
    const {
      reservation, loading, modalCancel, isSubsc, reservationSubsc, trade_id, finished,
      polling_ids, reservation_times, items, qrs, pay_token
    } = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title="QRコード"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />
        {modalCancel ? (
          <ModalCancel reservation={reservation}
            isSubsc={isSubsc}
            onCancel={this.onCancelConfirm}
          />
        ):(
          loading ? (
            <Indicator />
          ):(
            <ScrollView style={styles.scollview} showsVerticalScrollIndicator={false}>
              <View style={styles.part1}>
                <Text style={styles.text_header_part1}>{isSubsc ? reservationSubsc.nickname : reservation.nickname}</Text>
                <View style={styles.body_part1}>
                  <View style={styles.block1_part1}>
                    <Text style={[styles.text1_block1_part1, styles.text_enter]} >
                      {isSubsc ? reservationSubsc.items[0].title : reservation.item[0].title}
                    </Text>
                    <Text style={styles.text1_block1_part1}>
                      {isSubsc? reservationSubsc.items[0].knife : reservation.item[0].knife}
                    </Text> 
                  </View>

                  <View style={styles.block2_part1}>
                    <FontAwesomeIcon icon={faMapMarkerAlt} style={styles.icon_block2_part1} />
                    <Text style={styles.text_block2_part1}>
                      {isSubsc ? reservationSubsc.address : reservation.address}
                    </Text>
                  </View>
                </View>
              </View>
              
              {isSubsc ? (
                polling_ids.map((id, index) => {
                  if (items[index].qr.status != 2) {
                    return (
                      <QRComponent key={index} reservation={reservationSubsc} onCancel={this.onCancel} index={index}
                        polling_id={polling_ids[index]}
                        item={items[index]}
                        qr={qrs[index]}
                        reservation_time={reservation_times[index]}
                        trade_id={trade_id}
                      />
                    )
                  }
                })
              ):(
                <View style={styles.part２}>
                  <Text style={[styles.text_header_part2, {textAlign: 'center'}]}>予約時間：{reservation.reservation_time}</Text>
                  <View style={styles.body_part2}>
                    <FastImage source={{uri: reservation.qr[0].qr}} style={styles.qr_image} resizeMode='contain'>
                      {finished &&
                        <Text style={styles.fail_text}>
                          終了
                        </Text>
                      }
                      {(pay_token != '' && pay_token != null) &&
                        <View style={styles.cash}>
                          <TouchableOpacity style={styles.cash_sub}
                            onPress={this.onRefresh}
                          >
                            <FontAwesomeIcon icon={faSyncAlt} style={styles.icon_cash} size={dimen(3.2)} />
                            <Text style={styles.txt_cash2}>タップして更新</Text>
                          </TouchableOpacity>
                          <Text style={styles.txt_cash}>店舗にて有効になります</Text>
                        </View>
                      }
                    </FastImage>
                    {(pay_token != '' && pay_token != null) &&
                      <>
                        <Text style={styles.txt_reserve}>予約番号</Text>
                        <Text style={styles.txt_pay_token}>{pay_token}</Text>
                      </>
                    }
                    <Text style={styles.text_body_part2}>
                      スキャン後は無効
                    </Text>
                  </View>
                </View>
              )}
              
              {isSubsc ? (
                <View style={styles.part3}>
                </View>
              ):(
                <View style={styles.part3}>
                  <TouchableOpacity style = {styles.btnStyle1}
                    onPress = {() => this.onCancel(null, finished)}
                  >
                    <Text style = {styles.registerTextStyle1}>
                      {finished ? '評価する' : '予約をキャンセルする'}
                    </Text>
                  </TouchableOpacity>
                  {/* <TouchableOpacity style = {styles.btnStyle2}
                    onPress = {() => this.onFinish()}
                  >
                    <Text style = {styles.registerTextStyle}>クリックして詳細を見る</Text>
                  </TouchableOpacity> */}
                </View>
              )}
              
            </ScrollView>
          )
        )}
      </View>
    );
  }
}

class QRComponent extends PureComponent {
  constructor(props) {
    super(props)

    this.state = {
      show: false,
      reservation: props.reservation,
      index: props.index,
      finished: false,
      item: props.item,
      qr: props.qr,
      reservation_time: props.reservation_time,
      polling_id: props.polling_id,
    }
  }

  componentDidMount() {
    if (this.state.show) {
    }
  }

  onCancel = () => {
    const {index, finished} = this.state
    clearInterval(this.api_interval_sub);
    this.props.onCancel(index, finished)
  }
  onShow = (show) => () => {
    this.setState({show})
    if (show) {
      this.api_interval_sub_()
      this.api_interval_sub = setInterval(() => {
        this.api_interval_sub_()
      }, 3000);
    } else {
      clearInterval(this.api_interval_sub);
    }
  }
  api_interval_sub_ = () => {
    const {polling_id} = this.state
    const formData = new FormData();
    formData.append('polling_id', polling_id);
    
    const that = this
    Api.axios.post(Api.BASE_URL + 'polling', formData)
      .then(function (response) {
        // console.log("POLLING RESULT SUBSC", response.data)
        const code = response.data.code
        if (code == 1) {
          clearInterval(that.api_interval_sub);
          that.setState({finished: true})
        } else {
        }
      })
      .catch(function (error) {
        // console.log("ERROR POLLING SUBSC", error);
      })
  }

  render() {
    const {show, reservation, index, finished, item, qr, reservation_time, polling_id
    } = this.state

    return (
      <View style={[styles.part２, {marginVertical: dimen(2)}]}>
        <TouchableOpacity style={styles.flex}
          onPress={this.onShow(!show) }
        >
          <Text style={styles.text_header_part2}>予約時間{"\n"}{reservation_time}</Text>
          <Text style={styles.txt_qr}>QRコード表示</Text>
        </TouchableOpacity>
        {show &&
          <View style={styles.body_part2}>
            <FastImage source={{uri: qr}} style={styles.qr_image}>
              {finished &&
                <Text style={styles.fail_text}>
                  終了
                </Text>
              }
            </FastImage>
            <Text style={[styles.text_body_part2, {marginBottom: dimen(2)}]}>
              スキャン後は無効
            </Text>
            <TouchableOpacity style = {styles.btnStyle1}
              onPress={this.onCancel}
            >
              <Text style = {styles.registerTextStyle1}>
                {finished ? '評価する' : '予約をキャンセルする'}
              </Text>
            </TouchableOpacity>
          </View>
        }
      </View>
    )
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    position: 'relative',
    backgroundColor: colors.primaryColor
  },
  scollview: {
    flex: 1,
    margin: dimen(4),
    padding: dimen(2),
    paddingBottom: 100,
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2)
  },
  middleLogo: {
    alignSelf: 'center',
    width: dimen(16),
    height: dimen(16),
    marginTop: dimen(3),
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(5),
    marginTop: dimen(4),
    textAlign: 'center'
  },
  iconTextStyle1: {
    color: colors.redColor,
    fontSize: dimen(3.8),
    marginTop: dimen(3),
    paddingHorizontal: dimen(2),
    textAlign: 'center'
  },
  btnStyle2: {
    height: dimen(12),
    borderRadius: dimen(1),
    width: dimen(40),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
    fontSize: dimen(3.5),
  },
  btnStyle1: {
    height: dimen(11),
    borderRadius: dimen(1),
    width: dimen(40),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.whiteColor,
    borderColor: colors.primaryColor,
    borderWidth: 1,
    fontSize: dimen(3.2),
  },
  registerTextStyle : {
    color: 'white',
    fontSize: dimen(3.2)
  },
  registerTextStyle1 : {
    color: colors.primaryColor,
    fontSize: dimen(3.2)
  },
  part1: {
    marginVertical: dimen(4),
    padding: dimen(3),
    backgroundColor: 'white',
    borderRadius: 8
  },
  text_header_part1: {
    fontSize: dimen(4.5),
    fontWeight: "bold",
  },
  block1_part1: {
    flexDirection: "row",
    alignItems: 'center',
    justifyContent: "space-between",
    marginVertical: dimen(2)
  },
  text1_block1_part1: {
    fontSize: dimen(3.5)
  },
  block2_part1: {
    flexDirection: "row",
    marginTop: dimen(3)
  },
  icon_block2_part1: {
    color: colors.textColor
  },
  part２: {
    backgroundColor: 'white',
    borderRadius: 8
  },
  text_header_part2: {
    fontSize:dimen(4)
  },
  body_part2: {
    textAlign: "center",
    alignItems: "center",
  },
  qr_image: {
    width: dimen(40),
    height: dimen(40),
    position: 'relative',
    marginVertical: dimen(2)
  },
  finished: {
    width: dimen(40),
    height: dimen(40),
  },
  text_body_part2: {
    textAlign: "center",
    fontSize: dimen(4),
  },
  part3: {
    flexDirection: "row",
    justifyContent: "space-around",
    paddingTop: dimen(3),
    paddingBottom: 100
  },
  flex: {
    flexDirection: "row",
    alignItems: 'center',
    justifyContent: "space-between",
  },
  txt_qr: {
    color: 'gray'
  },
  fail_text: {
    position: 'absolute',
    left: 0, right: 0, top: 0, bottom: 0,
    fontSize: dimen(5),
    color: colors.whiteColor,
    backgroundColor: '#555555CC',
    textAlign: "center",
    lineHeight: dimen(40),
    fontWeight: "bold"
  },
  text_enter: {
    flex: 1,
    lineHeight: dimen(4.2),
    marginRight: dimen(2)
  },
  txt_reserve: {
    fontSize: dimen(3.5),
    lineHeight: dimen(4.5)
  },
  txt_pay_token: {
    borderRadius: dimen(1),
    lineHeight: dimen(11),
    width: dimen(40),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.whiteColor,
    borderColor: 'lightgray',
    borderWidth: 1,
    fontSize: dimen(4.5),
    textAlign: 'center',
    fontWeight: 'bold',
    marginBottom: dimen(3)
  },
  cash: {
    position: 'absolute',
    left: 0, right: 0, top: 0, bottom: 0,
    backgroundColor: '#CCEFFDEE',
    flexDirection: 'column-reverse'
  },
  txt_cash: {
    fontSize: dimen(3),
    fontWeight: 'bold',
    textAlign: 'center'
  },
  cash_sub: {
    flexDirection: 'row',
    alignItems: 'center',
    alignSelf: 'center',
    backgroundColor: 'white',
    borderRadius: dimen(1),
    paddingHorizontal: dimen(2),
    paddingVertical: dimen(1.5),
    elevation: 2,
    shadowColor: colors.primaryColor,
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.7,
    shadowRadius: 10,
    marginTop: dimen(3),
    marginBottom: dimen(6)
  },
  icon_cash: {
    color: '#7FCEFF',
    marginRight: dimen(1)
  },
  txt_cash2: {
    fontSize: dimen(3.5),
    color: '#7FCEFF'
  }
});

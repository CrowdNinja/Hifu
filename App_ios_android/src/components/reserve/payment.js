import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
  Linking,
  Alert
} from 'react-native';
import FastImage from 'react-native-fast-image'
import {
  SQIPCore,
  SQIPCardEntry
} from 'react-native-square-in-app-payments';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faMobileAlt, faChevronRight } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import LoadingPay from '../common/indicator_pay'
import ModalFinished from '../common/modal_payment_end'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext, SET_PAY_TYPE, SET_COUPON, SET_MY_MONEY, SET_TRADE, SET_SQUARE_ID } from '../../store/store'

import {SQUARE_APP_ID, SQURE_THEME} from '../../config/env'
import {ERR_DURATION} from '../../config/constant'

const IMG_BG = require('../../../assets/images/card_bg.png');

const CONST_PAYS = [
  [`クレジットカード決済${"\n"}(VISA, Mastercard, AMEXのみ対応)`, require('../../../assets/images/icon_pay_card.png')], 
  ['現金お支払い', require('../../../assets/images/icon_pay_money.png')], 
  ['LINE Pay', require('../../../assets/images/icon_pay_line.png')],
  ['残高支払い', require('../../../assets/images/icon_pay_ye.png')],
]

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    const params = props.route.params
    this.state = {
      token: context.state.token,
      shopname: params.shopname,
      shop_id: params.shop_id,
      pack_id: params.pack_id,
      isSubsc: params.isSubsc,

      data: null,
      initializing: true,
      cntCoupon: 0,
      indexPay: 0,
      loading: true,
      loadingPay: false,
      trade_id: null,
      flagEnd: false
    };

    context.dispatch({type: SET_COUPON, coupon: {money: 0}})
  }

  async componentDidMount() {
    await SQIPCore.setSquareApplicationId(SQUARE_APP_ID)
    if (Platform.OS !== 'android') {
      SQIPCardEntry.setIOSCardEntryTheme(SQURE_THEME)
    }

    const {token, shop_id, pack_id} = this.state
    const data = await Api.get_pay_info(token, shop_id, pack_id)
    const coupons = await Api.get_user_coupon(token, shop_id) ?? []

    this.setState({
      data,
      cntCoupon: coupons.filter(c => c.status == 1).length, 
      initializing: false,
      loading: false
    })
  }

  onCardNonceRequestSuccess = async (cardDetails) => {
    try {
      SQIPCardEntry.completeCardEntry(() => {
        this.setState({loading: true})
        this.onComplete(cardDetails.nonce) // ('cnon:card-nonce-ok') // 
      })
    } catch (error) {
      await SQIPCardEntry.showCardNonceProcessingError(error.message)
    }
  }
  async onCardEntryCancel() {}
  onStartCardEntry = async () => {
    const cardEntryConfig = { collectPostalCode: false }
    SQIPCardEntry.startCardEntryFlow(
      cardEntryConfig,
      this.onCardNonceRequestSuccess,
      this.onCardEntryCancel
    )
  }

  goOrder = () => {
    this.setState({flagEnd: false})
    this.props.navigation.navigate("TabHistory", {initial: 'RTabReserve'})
  }

  onComplete = async (nonce = null) => {
    const {token, shop_id, pack_id, data} = this.state
    const {coupon, pay_type, pay_password1} = this.context.state
    const responseOrder = await Api.pay_order(token, shop_id, pack_id, pay_type, nonce, pay_password1, coupon.id)
    // console.log(token, pay_type, shop_id, pack_id, nonce, pay_password1, coupon.id, responseOrder)

    const price = data.price > coupon.money ? data.price - coupon.money : 0
    const trade_id = responseOrder.data.trade_id
    // console.log(trade_id, price, data.price, coupon.money)
    if (!trade_id) {
      // Alert.alert(`${pack_id}____${SQUARE_APP_ID}`, JSON.stringify(responseOrder),
      Alert.alert(`購入できないメニューです`, '',
        [
          {
            text: '確認',
            onPress: () => this.setState({loading: false})
          },
        ]
      )
      return
    }

    this.context.dispatch({type: SET_TRADE, trade_id: trade_id})
    // const responseTrade = await Api.pay_trade(token, trade_id, pack_id, pay_type, password, coupon.id)

    if (pay_type == 6 || !price) { // 現金
      this.setState({trade_id, loading: false}, () => this.props.navigation.push("ReserveStep") )
    } else if (pay_type == 1) { // 残り
      this.setState({flagEnd: true, trade_id})
    } else if (pay_type == 4) { // LINE
      this.setState({trade_id})
      const url = responseOrder.data.info.paymentUrl
      Linking.canOpenURL(url.app).then(supported => {
        if (supported) {
          Linking.openURL(url.app);
        } else {
          Linking.canOpenURL(url.web).then(supported => {
            if (supported) {
              Linking.openURL(url.web);
            }
          });
        }
      });
    } else { // Credit
      const {square_customer_id} = responseOrder.data

      if (square_customer_id) {
        this.context.dispatch({
          type: SET_SQUARE_ID,
          square_customer_id: square_customer_id
        })
      }

      if (responseOrder.code == 88 ) {
        this.setState({loading: false}, () => 
          setTimeout(() =>
            this.setState({flagEnd: true, trade_id})  
          , ERR_DURATION)
        )
      } else {
        Alert.alert("クレジットカードエラー")
      }
    }
  }
  onCharge = async () => {
    const {indexPay, data} = this.state
    const {coupon} = this.context.state

    this.context.dispatch({
      type: SET_PAY_TYPE,
      pay_type: this.getPayType(indexPay)
    })

    const price = data.price > coupon.money ? data.price - coupon.money : 0
    if (!price) {
      this.props.navigation.push("PasswordStep", {mode: 1, onBack: () => this.onBack()})
      return
    }

    if (indexPay == 0) {// SQUARE
      const {square_customer_id} = this.context.state

      if (square_customer_id) {
        this.props.navigation.push("PasswordStep", {mode: 1, onBack: () => this.onBack()})
      } else this.onStartCardEntry()
    } else if (indexPay == 1) {
      this.setState({loading: true}, () => this.onComplete())
    } else if (indexPay == 2) {// LINE
      setTimeout(() => this.onComplete(), ERR_DURATION)
    } else if (indexPay == 3) {// 残り
      if (this.context.state.money >= price) {
        this.props.navigation.push("PasswordStep", {mode: 1, onBack: () => this.onBack()})
      } else {
        Alert.alert('残高がありません。')
      }
    } else {}
  }
  goReserve = () => {
    this.setState({flagEnd: false})
    this.props.navigation.push("ReserveStep")

    const {pay_type} = this.context.state
    if (pay_type == 1) {
      const {coupon, money} = this.context.state
      const {price} = this.state.data
      const sub_result = price - coupon.money > 0 ? price - coupon.money : 0
      this.context.dispatch({type: SET_MY_MONEY,
        money: parseInt(money) - parseInt(sub_result)
      })
    }
  }
  onBack = () => this.onComplete()
  getPayType = (index) => {
    if (index == 0) return 5 // CreditCard
    else if (index == 1) return 6 //現金
    else if (index == 2) return 4 //LINE
    else if (index == 3) return 1 //残り
    else return 0
  }
  onCheck = async () => {
    const {trade_id} = this.state
    const result = await Api.get_trade_status(trade_id)

    if (result == 1) {
      this.setState({loadingPay: false}, () => {
        setTimeout(() => {
          this.setState({flagEnd: true})
        }, 300)
      })
    } else {
      Alert.alert("お支払い結果を確認できません。")
    }
  }
  onCancel = () => this.setState({loadingPay: false})

  render() {
    const {
      cntCoupon,indexPay, loading, loadingPay, flagEnd, isSubsc, initializing,
      shopname, shop_id, pack_id, data
    } = this.state;
    const {coupon, money} = this.context.state

    return (
      <View style={styles.container}>
        <TopBar
          title="お支払い"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {loading && <Indicator />}
        {loadingPay && <LoadingPay onCheck={this.onCheck} onCancel={this.onCancel} />}
        {flagEnd &&
          <ModalFinished
            onReserve={this.goReserve}
            onOrder={this.goOrder}
          />
        }

        {!initializing &&
          <ScrollView contentContainerStyle={{padding: dimen(3)}}>
            <FastImage source={IMG_BG}>
              <View style={styles.headerTopStyle}>
                <Text style={styles.text1_block1_part1_header}>{shopname}</Text>
                <View style={styles.block1_part1_header}>
                  <Text style={styles.text2_block1_part1_header}>{data.pack_title}</Text>
                  <Text style={styles.text_piece4_header}>
                    1回
                  </Text>
                </View>
              </View>
              <Text style={styles.price}>
                <Text style={styles.price_title}>合計： </Text>{data.price > coupon.money ? data.price - coupon.money : 0}円
              </Text>
            </FastImage>

            <TouchableOpacity style={styles.part2}
              onPress={() => this.props.navigation.push( "CouponStep", {shop_id: shop_id} )}
            >
              <Text style={styles.txt_part2}>クーポン</Text>
              <View style={styles.view_coupon_part}>
                <Text style={styles.txt_coupon}>
                  { coupon.id ? `${coupon.money}円取得` : `${cntCoupon}枚` }
                </Text>
                <FontAwesomeIcon icon={faChevronRight} color='gray' />
              </View>
            </TouchableOpacity>

            <View style={styles.part4}>
              <Text style={styles.txt_part4}>お支払い方法の選択</Text>
              {CONST_PAYS.map((pay, index) => {
                if (isSubsc && index > 0) return (<View key={index}/>)
                return (
                  <TouchableOpacity key={index} style={styles.radio_group_part4}
                    onPress={() => this.setState({indexPay: index})}
                  >
                    <View style={styles.block1_part4}>
                      <FastImage style={styles.icon_part4} source={pay[1]} resizeMode='contain' />
                      <Text style={styles.textRadioButton}>
                        {pay[0]}{index == 3 ? `（${money} 円）` : ''}
                      </Text>
                    </View>
                    <View style={indexPay == index ? styles.checked_wrapper : styles.unchecked_wrapper}>
                      <View style={indexPay == index ? styles.checkedCircle : styles.uncheckedCircle}/>
                    </View>
                  </TouchableOpacity>
                )
              })}
            </View>

            <TouchableOpacity style={styles.part3}
              onPress={this.onCharge}
            >
              <Text style={styles.text_block1_part3}>お支払い確認</Text>
            </TouchableOpacity>
          </ScrollView>
        }
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    position: 'relative'
  },
  part1: {
  },
  headerTopStyle: {
    borderBottomWidth: 1,
    borderBottomColor: colors.grayColor,
    marginHorizontal: dimen(3),
    paddingVertical: dimen(5.8)
  },
  price_title: {
    color: colors.blackColor,
    fontSize: dimen(4)
  },
  block1_part1_header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between'
  },
  text2_block1_part1_header: {
    fontSize: dimen(4),
    lineHeight: dimen(4.5),
    marginRight: dimen(9),
    flexShrink: 1
  },
  text1_block1_part1_header: {
    fontSize: dimen(4.5),
    paddingVertical: dimen(2)
  },
  price:{
    textAlign: "right",
    paddingRight: dimen(3),
    fontSize: dimen(5),
    color: colors.redColor,
    paddingVertical: dimen(3)
  },
  text_piece4_header: {
    textAlign: "right",
    color: colors.blackColor,
    fontSize: dimen(4),
  },
  part2: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: colors.whiteColor,
    padding: dimen(3),
    paddingVertical: dimen(4),
    marginVertical: dimen(4),
    borderRadius: 6
  },
  view_coupon_part: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  txt_coupon: {
    color: 'red',
    fontSize: dimen(4)
  },
  txt_part2: {
    fontSize: dimen(4.5)
  },
  txt_part4: {
    fontSize: dimen(4.5),
    paddingVertical: dimen(4)
  },
  part3: {
    marginHorizontal: dimen(3),
    marginVertical: dimen(8),
    backgroundColor: colors.primaryColor,
    textAlign: "center",
    borderRadius: dimen(6),
    overflow: "hidden"
  },
  text_block1_part3: {
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(12),
    fontSize: dimen(4.5)
  },
  part4: {
    backgroundColor: colors.whiteColor,
    paddingHorizontal: dimen(3),
    borderRadius: dimen(2)
  },
  radio_group_part4: {
    flexDirection: 'row',
    backgroundColor: 'white',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: dimen(3),
    borderTopWidth: 1,
    borderTopColor: colors.grayColor
  },
  block1_part4: {
    flexDirection: "row",
    alignItems: "center"
  },
  icon_part4: {
    width: dimen(7.2),
    height: dimen(7.2),
    resizeMode: 'contain'
  }, 
  checked_wrapper: {
    height: 24,
    width: 24,
    borderRadius: 12,
    borderWidth: 1,
    borderColor: colors.primaryColor,
    alignItems: 'center',
    justifyContent: 'center',
  },
  unchecked_wrapper: {
    height: 24,
    width: 24,
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E6E6E6',
    alignItems: 'center',
    justifyContent: 'center',
  },
  checkedCircle: {
      width: 14,
      height: 14,
      borderRadius: 9,
      backgroundColor: colors.primaryColor,
  },
  uncheckedCircle: {
      width: 14,
      height: 14,
      borderRadius: 7,
      backgroundColor: '#E6E6E6',
  },
  textRadioButton: {
    color: colors.blackColor,
    fontSize: dimen(4),
    lineHeight: dimen(5),
    paddingLeft: dimen(2),

  },
});

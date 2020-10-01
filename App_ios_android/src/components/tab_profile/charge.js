import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
  TextInput,
  TouchableWithoutFeedback,
  Keyboard,
  Linking,
  Alert,
  Platform
} from 'react-native';
import FastImage from 'react-native-fast-image'
import {
  SQIPCore,
  SQIPCardEntry
} from 'react-native-square-in-app-payments';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ModalCharge from './modalCharge'

import {dimen, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext, SET_MY_MONEY, SET_SQUARE_ID } from '../../store/store'
import * as Api from '../../apis/api'

import {SQUARE_APP_ID, SQURE_THEME} from '../../config/env'
import {ERR_DURATION} from '../../config/constant'

const IMG_CHECK = require('../../../assets/images/tc_check.png');

const CONST_PAYS = [
  [`クレジットカード決済${"\n"}(VISA, Mastercard, AMEXのみ対応)`, require('../../../assets/images/icon_pay_card.png')], 
  ['LINE Pay', require('../../../assets/images/icon_pay_line.png')],
]

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      loading: true,
      flagEnd: false,
      success: true,
      visible: true,
      prices: [],
      indexPrice: 0,
      indexPay: 0,
      price: '',
    };
  }

  async componentDidMount() {
    await SQIPCore.setSquareApplicationId(SQUARE_APP_ID)
    if (Platform.OS !== 'android') {
      SQIPCardEntry.setIOSCardEntryTheme(SQURE_THEME)
    }
    this.api_get_charge()
  }

  onCardNonceRequestSuccess = async (cardDetails) => {
    try {
      SQIPCardEntry.completeCardEntry(() => {
        this.setState({loading: true})
        this.api_charge(cardDetails.nonce) //('cnon:card-nonce-ok') //
      })
    } catch (error) {
      await SQIPCardEntry.showCardNonceProcessingError(error.message)
    }
  }
  onCardEntryCancel = async () => {}
  onStartCardEntry = async () => {
    const cardEntryConfig = { collectPostalCode: false }
    await SQIPCardEntry.startCardEntryFlow(
      cardEntryConfig,
      this.onCardNonceRequestSuccess,
      this.onCardEntryCancel
    )
  }

  onCharge = () => {
    if (this.state.indexPay == 0) {
      const {square_customer_id} = this.context.state

      if (square_customer_id) {
        this.props.navigation.push("PaymentPasswordScreen", {mode: 1, onBack: () => this.onBack()})
      } else this.onStartCardEntry()
    } else {
      this.setState({loading: true, visible: true})
      this.api_charge()
    }
  }
  onClose = () => this.setState({flagEnd: false, visible: false})
  onBack = () => this.api_charge()

  async api_get_charge() {
    const prices = await Api.get_recharge()
    this.setState({prices, loading: false, price: prices[0].redmoney})
  }

  async api_charge(nonce = null) {
    const {token, indexPrice, indexPay, price} = this.state

    const data = await Api.charge(token, indexPay == 0 ? 5 : 4, indexPrice, price, nonce)
    this.setState({loading: false})

    if (data) {
      if (indexPay == 0) {
        if ( data.code == 88) {
          const {square_customer_id} = data.data

          if (square_customer_id) {
            this.context.dispatch({
              type: SET_SQUARE_ID,
              square_customer_id: square_customer_id
            })
          }

          this.context.dispatch({ type: SET_MY_MONEY, money: data.data.current_money})
          setTimeout(() => {
            this.setState({flagEnd: true, success: true})
          }, ERR_DURATION)
        } else {
          setTimeout(() => {
            Alert.alert('エラー', '購入できません', [
              {
                text: '確認',
                onPress: () => this.setState({flagEnd: true, success: false})
              }
            ])
          }, ERR_DURATION)
        }
      } else {
        const url = data.data.info.paymentUrl
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
      }
    }
  }

  render() {
    const {
      loading, prices, indexPrice, indexPay, price, flagEnd, success, visible
    } = this.state

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <View style={styles.container}>
        <TopBar
          title="チャージ"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {flagEnd && <ModalCharge success={success} onClose={this.onClose}/>}

        <View style={styles.headerTopStyle}>
          <TextInput
            style={styles.block1_part1_header}
            placeholder="その他の金額"
            placeholderTextColor="gray"
            keyboardType='numeric'
            value={price}
            onChangeText={text => this.setState({price: text, indexPrice: null})}
          />
          <TouchableOpacity style={styles.piece4_header}>
            <Text style={styles.text_piece4_header}>
              即チャージ
            </Text>
          </TouchableOpacity>
        </View>
        {loading && <Indicator/> }

        <View style={styles.wrapper}>
          <View style={styles.part2}>
            <Text style={styles.part2_header_text}>即チャージ</Text>
            <View style={styles.block1_part2}>
              {prices.map((price, index) => {
                return (
                  <TouchableOpacity key={index} style={styles.piece1_block1_part2}
                    onPress={() => this.setState({indexPrice: index, price: parseInt(price.redmoney) + ''} )}
                  >
                    <Text style={styles.piece1_1_2_block1_part2}>チャージ{price.redmoney}円</Text>
                    {indexPrice == index &&
                      <FastImage 
                        style={styles.piece1_1_1_block1_part2_selected}
                        source={IMG_CHECK}
                      />
                    }
                  </TouchableOpacity>
                )
              })}
            </View>
          </View>

          <Text style={styles.part3_header_text}>お支払い方法の選択</Text>
          <ScrollView contentContainerStyle={{flex: 1}}>
            {CONST_PAYS.map((pay, index) => {
              return (
                <TouchableOpacity key={index} style={styles.radio_group_part4}
                  onPress={() => this.setState({indexPay: index})}
                >
                  <View style={styles.block1_part4}>
                    <FastImage style={styles.icon_part4} source={pay[1]} resizeMode={FastImage.resizeMode.contain}/>
                    <Text style={styles.textRadioButton}>{pay[0]}</Text>
                  </View>
                  <View style={indexPay == index ? styles.checked_wrapper : styles.unchecked_wrapper}>
                    <View style={indexPay == index ? styles.checkedCircle : styles.uncheckedCircle}/>
                  </View>
                </TouchableOpacity>
              )
            })}
          </ScrollView>
        </View>
        
        <TouchableOpacity style={styles.part3}
          onPress={this.onCharge}
        >
          <View style={styles.block1_part3}>
            <Text style={styles.text_block1_part3}>お支払い確認</Text>
          </View>
        </TouchableOpacity>
      </View>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  wrapper: {
    flex: 1,
    backgroundColor: 'white',
    marginTop: dimen(3),
    padding: dimen(3)
  },
  headerTopStyle: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
    backgroundColor: colors.whiteColor,
    padding: dimen(3)
  },
  block1_part1_header: {
    flex: 1,
    fontSize: dimen(5),
    color: 'gray'
  },
  piece4_header: {
    display: 'none',
    backgroundColor: colors.primaryColor,
    paddingVertical: dimen(2),
    paddingHorizontal: dimen(4),
    borderRadius: dimen(10)
  },
  text_piece4_header: {
    fontSize: dimen(4.5),
    color: colors.whiteColor,
  },
  part2: {
    backgroundColor: colors.whiteColor,
  },
  part2_header_text: {
    fontSize: dimen(4.5),
    color: "black",
  },
  part3_header_text: {
    fontSize: dimen(4.5),
    color: "black",
    marginTop: dimen(6),
    marginBottom: dimen(3)
  },
  block1_part2: {
    flexDirection: "row",
    justifyContent: "space-between",
    flexWrap: "wrap"
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
  },
  piece1_1_2_block1_part2: {
    fontSize: dimen(4),
    color: colors.blackColor,
    textAlign: "center"
  },
  piece1_block1_part2: {
    marginTop: dimen(3.6),
    paddingVertical: dimen(5),
    width: dimen(45.6),
    borderRadius: dimen(2),
    borderWidth: 1,
    borderColor: colors.grayColor
  },
  piece1_1_1_block1_part2_selected: {
    position: "absolute",
    right: 0,
    bottom: 0,
    width: dimen(6.8),
    height: dimen(6.8)
  },
  part3: {
    position: 'absolute',
    bottom: dimen(4),
    left: dimen(4),
    right: dimen(4)
  },
  block1_part3: {
    backgroundColor: colors.primaryColor,
    textAlign: "center",
    borderRadius: dimen(6),
    overflow: "hidden"
  },
  text_block1_part3: {
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(10),
    fontSize: dimen(5)
  },
  part4: {
    backgroundColor: colors.whiteColor,
    paddingTop: dimen(3.2),
    paddingLeft: dimen(3.2),
    paddingRight: dimen(3.2)
  },
  part4_header: {
    paddingBottom: dimen(3.2)
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
    paddingLeft: dimen(2)
  },
});

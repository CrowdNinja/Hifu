import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
  TextInput,
  KeyboardAvoidingView,
  Platform,
  Alert
} from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faCalendarAlt, faMobileAlt, faPencilAlt, faChevronRight } from '@fortawesome/free-solid-svg-icons';
import CheckBox from 'react-native-check-box'
import moment from 'moment'

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext, SET_TIMES } from '../../store/store'


export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    const {token, account, trade_id} = context.state

    this.state = {
      loading: true,
      user_count: 0,
      token: token,
      phone: account,

      items: [],
      trade_id: trade_id,
      indexItem: 0,
      remark: '',

      subscItems: [],
      selectedIndex: 0,
      reservetime: ''
    };

    context.dispatch({type: SET_TIMES, times: []})
  }

  componentDidMount() {
    this.api_get_reserve()
  }

  onBack = () => {
    const {isSubsc, selectedIndex, subscItems} = this.state
    const {times} = this.context.state

    if (isSubsc) {
      subscItems[selectedIndex].map((item, index) => {
        subscItems[selectedIndex][index].reserve_time = times.length < index ? times[index] : null
      })
      times.map((time, index) => subscItems[selectedIndex][index].reserve_time = time)
      this.setState({subscItems: [...subscItems]})
    }
  }

  onSelect = (index, id, pack_id, limits) => () => {
    const {trade_id, subscItems} = this.state

    this.setState({selectedIndex: index})
    this.props.navigation.push('TimeSelectStep', {
      isSubsc: true, trade_id: trade_id, item_id: id, pack_id: pack_id,
      subscItems: subscItems, limits: limits,
      onBack: () => this.onBack() 
    })
  }
  onReserve = async () => {
    const {isSubsc, subscItems} = this.state
    const {times} = this.context.state

    if (isSubsc) {
      const items = []
      subscItems.map(subItems => {
        subItems.map(item => {
          if (item.reserve_time) items.push([item.id, item.reserve_time])
        })
      })

      if (!items.length) {
        Alert.alert("日時を選択してください")
        return
      } else {
        this.api_set_reserve(items)
      }
    } else {
      if (!times.length) {
        Alert.alert("日時を選択してください")
        return
      } else {
        this.api_set_reserve()
      }
    }
  }

  api_set_reserve = async (timeItems = null) => {
    const {isSubsc, token, phone, trade_id, items, remark, indexItem} = this.state
    const {times} = this.context.state
    var result = 0

    if (isSubsc) {
      result = await Api.reservation_order_subsc(token, trade_id, timeItems, phone, remark)
    } else {
      result = await Api.reservation_order(token, trade_id, items.filter((item, index) => index == indexItem).map(item => item.id).join(','), times[0], phone, remark)
    }
    // console.log("____", token, trade_id, timeItems, phone, remark, result)
    this.setState({loading: false})

    if (result == 1) {
      this.props.navigation.push("ReserveConfirmStep", {isSubsc: isSubsc})
    } else {
      setTimeout(() => {
        Alert.alert("予約失敗しました。")
        return
      }, 400)
    }
  }

  async api_get_reserve() {
    const {token, trade_id} = this.state
    const data = await Api.get_reserve_item(token, trade_id)

    const items = data[0]
    const isSubsc = data[1]
    var subscItems = []

    if (isSubsc) {
      const ids = Array.from(new Set(items.map(d => d.pack_item_id)))
      ids.map(id => subscItems.push(items.filter(item => item.pack_item_id == id)))
    }

    const reservetime = moment(data[3], 'YYYY-MM-DD HH:mm').add(1, 'M').format('M月D日')

    this.setState({items, subscItems, loading: false, reservetime, isSubsc})
  }

  onTimeSelect = (index) => () => {
    const {trade_id, items} = this.state

    this.props.navigation.push('TimeSelectStep', {
      trade_id: trade_id,
      item_id: items[index].id,
      onBack: () => this.onBack() 
    })
  }

  render() {
    const {indexItem, loading, phone,
      items, trade_id, remark, isSubsc, subscItems, reservetime
    } = this.state;
    const {times} = this.context.state

    return (
      <View style={styles.container}>
        <TopBar 
          title="予約" 
          backColor={colors.primaryColor} 
          navigation={this.props.navigation}
        />

          <KeyboardAvoidingView style={{flex: 1}}
            behavior={Platform.OS === 'ios' ? "height" : 'height'}
            enabled
          >
          <ScrollView contentContainerStyle={styles.scrollview}
            showsVerticalScrollIndicator={false}
          >
            {loading && <Indicator /> }
            {isSubsc ? (
              <>
                <Text style={styles.container_header}>予約日時は後から決めることができます。</Text>
                {
                  subscItems.map((subItems, i) => {
                    var cntTime = 0
                    return (
                      <View key={i} style={[styles.box, styles.subsc]}>
                        {subItems.map((item, j) => {
                          if (item.reserve_time) cntTime++
                          const isNotFull = (cntTime != subItems.length && j == subItems.length - 1)

                          return (
                            <View key={j}>
                              {(item.reserve_time || isNotFull) &&
                                <TouchableOpacity key={j} style={[styles.box, styles.subsc_item, item.reserve_time? styles.selected_box: '']}
                                  onPress={this.onSelect(i, item.id, item.pack_item_id, subItems.length)}
                                >
                                  <View style={styles.box_left}>
                                    <FontAwesomeIcon icon={faCalendarAlt} style={[styles.icon_fontawesome, item.reserve_time? styles.selected_text: '']} />
                                    <Text style={[styles.box_txt, item.reserve_time? styles.selected_text: '']}>予約時間を選択</Text>
                                  </View>
                                  <View style={styles.flex}>
                                    <Text style={[styles.box_txt_detail, item.reserve_time? styles.selected_text: {}]}>{item.reserve_time ?? reservetime + 'までにご予約ください'}</Text>
                                    <FontAwesomeIcon icon={faChevronRight} color={item.reserve_time? colors.whiteColor: colors.blackColor} />
                                  </View>
                                </TouchableOpacity>
                              }
                            </View>
                          )
                        })}
                        <View style={styles.flex_space}>
                          <View>
                            <Text style={styles.txt_sub_title}>{subItems[0].item_name}</Text>
                            <Text style={styles.txt_sub_desc}>{subItems[0].knife}ショット</Text>
                          </View>
                          <Text style={styles.txt_sub_num}>{subItems.length} 回</Text>
                        </View>
                      </View>
                    )}
                  )
                }
                </>
            ):(
              <TouchableOpacity style={styles.box}
                onPress={this.onTimeSelect(indexItem)}
              >
                <View style={styles.box_left}>
                  <FontAwesomeIcon icon={faCalendarAlt} style={styles.icon_fontawesome} />
                  <Text style={styles.box_txt}>時間</Text>
                </View>
                {(times.length > 0) &&
                  <Text style={styles.box_txt_detail}>{moment(times[0]).format('YYYY年MM月DD日 AHH:mm')}</Text>
                }
              </TouchableOpacity>
            )}
            
            <View style={styles.box}>
              <View style={styles.box_left}>
                <FontAwesomeIcon icon={faMobileAlt} style={styles.icon_fontawesome} />
                <Text style={styles.box_txt}>予約の電話番号：</Text>
              </View>
              <Text style={styles.box_txt_detail}>{phone}</Text>
            </View>
            
            {!isSubsc &&
              <View style={[styles.box, styles.packs]}>
                {items.map((item, index) => {
                  return (
                    <View key={index} style={styles.view_pack}>
                      <CheckBox
                        style={styles.checkboxContainerStyle}
                        onClick={ () => { this.setState({indexItem: index}) } }
                        isChecked={indexItem == index}
                        rightText={item.item_name}
                        rightTextStyle={styles.txt_checkbox}
                        checkBoxColor={colors.primaryColor}
                        checkedCheckBoxColor={colors.primaryColor}
                        uncheckedCheckBoxColor={'lightgray'}
                      />
                      <Text style={styles.txt_pack}>{item.knife}ショット</Text>
                    </View>
                  )
                })}
              </View>
            }
            
            <View style={[styles.box, styles.view_comment]}>
              <FontAwesomeIcon icon={faPencilAlt} color='gray' />
              <TextInput style={styles.txt_input}
                value={remark}
                onChangeText={text => this.setState({remark: text})}
                multiline={true}
                numberOfLines={6}
                placeholder="店舗への連絡事項があればご記入ください。"
              />
            </View>

            <TouchableOpacity style={styles.part3}
              onPress={this.onReserve}
            >
              <Text style={styles.text_block1_part3}>予約する</Text>
            </TouchableOpacity>
          </ScrollView>
          </KeyboardAvoidingView>
          {/* <View style={styles.footer}>
            
          </View> */}
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    position: 'relative'
  },
  scrollview: {
    padding: dimen(3),
    paddingBottom: 100
  },
  container_header: {
    backgroundColor: colors.whiteColor,
    color: colors.blackColor,
    fontSize: dimen(4),
    lineHeight: dimen(8),
    borderWidth: 1,
    borderColor: colors.gray230,
    paddingHorizontal: dimen(4),
    marginVertical: dimen(3)
  },
  icon_fontawesome: {
    color: 'gray',
    bottom: dimen(0.3)
  },
  box: {
    backgroundColor: 'white',
    marginBottom: dimen(3),
    overflow: "hidden",
    padding: dimen(3),
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  view_comment: {
    // height: dimen(50)
    alignItems: "flex-start"
  },
  box_left: {
    flexDirection: 'row',
    alignItems: 'center'
  },
  box_txt: {
    marginLeft: dimen(2),
    lineHeight: 30
  },
  box_right_user_select: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  btn: {
    width: 30,
    height: 30,
    borderRadius: dimen(1),
    alignItems: 'center',
    justifyContent: 'center',
  },
  minus: {
    borderColor: 'lightgray'
  },
  plus: {
    borderColor: colors.primaryColor
  },
  txt_minus: {
    color: 'lightgray'
  },
  txt_plus: {
    color: colors.primaryColor
  },
  text_user_count: {
    borderWidth: 1,
    lineHeight: 28,
    borderColor: 'lightgray',
    width: dimen(15),
    textAlign: 'center',
    marginHorizontal: dimen(3),
    borderRadius: dimen(1)
  },
  packs: {
    flexDirection: 'column',
  },
  view_pack: {
    width: '100%',
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 6
  },
  checkboxContainerStyle: {
    flex: 1
  },
  txt_checkbox: {
    marginLeft: dimen(1),
    flexShrink: 1,
    marginRight: dimen(5)
  },
  txt_input: {
    margin: 0,
    padding: 0,
    flex: 1,
    marginLeft: dimen(2),
    height: dimen(50),
    backgroundColor: colors.whiteColor
  },
  footer: {
    position: "absolute",
    bottom: 0,
    width: dimen(100),
    backgroundColor: colors.whiteColor,
    paddingTop: dimen(3)
  },
  part3: {
    marginHorizontal: dimen(6),
    marginVertical: dimen(6),
    height: dimen(12),
    borderRadius: dimen(6),
    backgroundColor: colors.primaryColor,
  },
  text_block1_part3: {
    color: 'white',
    fontSize: dimen(5),
    textAlign: 'center',
    lineHeight: dimen(12)
  },
  subsc: {
    flexDirection: 'column',
    alignItems: 'stretch',
    justifyContent: 'flex-start',
    padding: 0,
    margin: 0,
    borderRadius: dimen(2),
  },
  subsc_item: {
    padding: 0,
    marginBottom: 0,
    paddingVertical: dimen(2),
    paddingHorizontal: dimen(4)
  },
  flex: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  flex_space: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: dimen(4),
    paddingVertical: dimen(2),
    backgroundColor: colors.grayBlack,
    borderTopWidth:1,
    borderTopColor: colors.whiteColor
  },
  txt_sub_title: {
    fontSize: dimen(4),
    lineHeight: dimen(8),
    color: colors.whiteColor
  },
  txt_sub_desc: {
    fontSize: dimen(3.5),
    paddingBottom: dimen(2),
    color: colors.whiteColor,
  },
  txt_sub_num: {
    fontSize: dimen(4),
    color: colors.whiteColor
  },
  selected_text: {
    color: colors.whiteColor
  },
  selected_box: {
    backgroundColor: colors.grayBlack
  }
});

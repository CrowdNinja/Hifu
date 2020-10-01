import React, {PureComponent} from 'react';
import {
  StyleSheet,
  Alert,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import FastImage from 'react-native-fast-image';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faPen, faYenSign } from '@fortawesome/free-solid-svg-icons';
import moment from 'moment';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext, SET_TRADE } from '../../store/store'
import * as Api from '../../apis/api'

const ICON_DEFAULT = require('../../../assets/images/icon_category1.png');
const ICON_SUBSC = require('../../../assets/images/icon_badge_yoyaku.jpg');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      urlUser: props.item.thumb,
      urlPack: props.item.pack_img,
      status: parseInt(props.kind),
      index: props.index,
    };
  }

  getBtns = (kind) => {
    switch(kind) {
      case 0:
        return ['キャンセル', '支払い']
      case 1:
        return [null, '予約する']
      case 2:
        return [null, 'QRコード']
      case 4:
        return [null, '評価へ']
      case 3:
        return [null, '再度購入']
      default:
        return [null, null]
    }
  }

  isBlueBtn = (kind, status) => {
    return kind == 1 & status == 1
  }

  onCancel = () => {
    const {status, index, token} = this.state
    const {item} = this.props
  
    switch(status) {
      case 0:
      case 1:
        Alert.alert(
          '確認',
          '削除しますか？',
          [
            {
              text: 'はい',
              onPress: () => {
                Api.del_trade(token, item.id)
                this.props.onRemove(index)
              }
            },
            {
              text: 'いいえ',
              onPress: () => {
              },
              style: 'cancel'
            },
          ],
          { cancelable: false }
        );
        return
      case 2:
        Alert.alert(
          '確認',
          'キャンセルしますか？',
          [
            {
              text: 'はい',
              onPress: () => {
                this.context.dispatch({type: SET_TRADE, trade_id: item.id})
                this.props.navigation.navigate("ReservationStack", {
                  screen: 'ReserveConfirmStep',
                  params: {
                    cancelable: true
                  }
                })
              }
            },
            {
              text: 'いいえ',
              onPress: () => {
              },
              style: 'cancel'
            },
          ],
          { cancelable: false }
        );
        return
      case 4:
        return
      case 3:
        return
    }
  }

  onSubmit = () =>{
    const {status, index, token} = this.state
    const {item} = this.props
  
    switch(status) {
      case 1:
        this.context.dispatch({type: SET_TRADE, trade_id: item.id})
        this.props.navigation.navigate("ReservationStack", {initial: 'ReserveStep'})
        return
      case 2:
        this.context.dispatch({type: SET_TRADE, trade_id: item.id})
        this.props.navigation.navigate("ReservationStack", {
          screen: 'ReserveConfirmStep',
          params: {
            isSubsc: item.subscription_flg == 1
          }
        })
        return
    }
  }

  goShop = (shop_id) => () => {
    this.props.navigation.navigate("ShopStack", {
      screen: 'ShopScreen',
      params: {
        shop_id: shop_id
      }
    })
  }

  render() {
    const {item} = this.props;

    const {urlUser, urlPack, status} = this.state;
    const btns = this.getBtns(status)
    const isBlueBtn = this.isBlueBtn(status, item.subscription_flg)

    return (
      <View style={styles.fullStyle}>
        <View style={styles.header_p}>
          <View style={styles.header}>
            <TouchableOpacity style={[styles.border_bebel, {borderRadius: dimen(5)}]}
              onPress={this.goShop(item.adminid)}
            >
              <CustomFastImage
                url={urlUser}
                style={styles.image_header}
              />
            </TouchableOpacity>
            <Text style={styles.text_header}>{item.shop_nickname}</Text>
          </View>
        </View>
       
        <View style={styles.part1}>
          <View style={styles.border_bebel}>
            <CustomFastImage
              url={urlPack}
              style={styles.image_part1}
            />
          </View>
          
          <View style={styles.menu_item}>
            <Text style={styles.menu_title} numberOfLines={1}>{item.pack_title}</Text>
            <View style={styles.menu_body}>
              {item.subscription_flg == 1 &&
                <FastImage source={ICON_SUBSC} style={styles.img_subsc}/>
              }
              <View style={styles.menu_info}>
                <View style={styles.info_icon}>
                  <FontAwesomeIcon icon={faYenSign} size={dimen(2.5)} color='white' />
                </View>
                <Text style={styles.info_text}>{parseInt(item.money)}</Text>
              </View>
            </View>
            <Text style={styles.text1_content_part1} numberOfLines={1}>
              注文時間: {moment(item.ctime).format('M月D日HH:mm')}
            </Text>
          </View>
        </View>
        {status > -1 &&
          <View style={styles.part2}>
            {btns[0] &&
              <TouchableOpacity style={[styles.button_part2, styles.button1_part2]}
                onPress={() => this.onCancel()}
              >
                <Text style={styles.text_button1_part2}>
                  {btns[0]}
                </Text>
              </TouchableOpacity>
            }
            
            <TouchableOpacity style={[styles.button_part2, styles.button2_part2, isBlueBtn ? {backgroundColor: colors.primaryColor} : {}]}
              onPress={() => this.onSubmit()}
            >
              <Text style={[styles.text_button2_part2]}>
                {isBlueBtn ? 'サブスクを予約' : btns[1]}
              </Text>
            </TouchableOpacity>
          </View>
        }
      </View>
    );
  }
}

class CustomFastImage extends React.PureComponent {
  constructor(props) {
    super(props)

    this.state = {
      url: props.url,
      style: props.style
    }
  }

  render() {
    const {url, style} = this.state

    return (
      <FastImage
        source={url ? {uri: url} : ICON_DEFAULT }
        style={style}
        onError={() => this.setState({url: null})}
        resizeMode={url ? 'cover' : 'center'}
      />
    )
  }
}

const styles = StyleSheet.create({
  fullStyle: {
    marginHorizontal: dimen(3),
    backgroundColor: colors.whiteColor,
    paddingVertical: dimen(2),
    borderRadius: dimen(2),
    marginTop: dimen(3),
    elevation: 2,
    shadowColor: 'black',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
  },
  border_bebel: {
    shadowColor: 'black',
    shadowOffset: { width: 1, height: 1 },
    borderRadius: 6,
    shadowOpacity: 0.3,
    backgroundColor: 'transparent',
    shadowRadius: 1,
    elevation: 2,
  },
  header_p: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: 'space-between',
    marginHorizontal: dimen(3),
    paddingBottom: dimen(1.5),
    borderBottomWidth: 1,
    borderBottomColor: colors.grayColor
  },
  header: {
    flexDirection: "row",
    alignItems: "center"
  },
  image_header: {
    width: dimen(10),
    height: dimen(10),
    borderRadius: dimen(5),
    backgroundColor: 'white'
  },
  text_header: {
    marginLeft: dimen(1),
    fontSize: dimen(3.8),
    flexShrink: 1
  },
  part1: {
    flexDirection: "row",
    paddingVertical: dimen(3),
    marginHorizontal: dimen(3),
    alignItems: "center",
    borderBottomWidth: 1,
    borderBottomColor: colors.grayColor
  },
  image_part1: {
    width: dimen(14.4),
    height: dimen(14.4),
    borderRadius: 6,
    backgroundColor: 'white'
  },
  text1_content_part1: {
    fontSize: dimen(3.2),
    flexShrink: 1,
    color: 'gray'
  },
  text2_content_part1: {
    fontSize: dimen(3.8),
    paddingTop: dimen(1),
    color: colors.blackColor
  },
  part2: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "flex-end",
    marginTop: dimen(2)
  },
  button_part2: {
    width: dimen(30),
    height: dimen(8),
    borderRadius: dimen(4),
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: dimen(5),
  },
  button1_part2: {
    backgroundColor: colors.whiteColor,
    borderColor: colors.grayColor,
    borderWidth: 1,
  },
  text_button1_part2: {
    color: colors.blackColor,
    fontSize: dimen(3.8),
    lineHeight: dimen(7)
  },
  text_button2_part2: {
    color: colors.whiteColor,
    fontSize: dimen(3.8),
    lineHeight: dimen(7)
  },
  button2_part2: {
    backgroundColor: colors.pinkColor,
  },
  button3_part2: {
    backgroundColor: colors.primaryColor,
  },
  menu_item: {
    flex: 1,
    paddingLeft: dimen(2),
  },
  menu_body: {
    flexDirection: "row",
    alignItems: "center",
    marginVertical: dimen(0.8)
  },
  menu_info: {
    flexDirection: "row",
    alignItems: "center",
    marginRight: 8
  },
  info_icon: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: 'center',
    backgroundColor: colors.primaryColor,
    width: dimen(3),
    height: dimen(3),
    marginRight: 4
  },
  info_text: {
    fontSize: dimen(3)
  },
  menu_title: {
    flexShrink: 1,
    fontSize: dimen(3.5)
  },
  img_subsc: {
    width: dimen(20),
    height: undefined,
    aspectRatio: 1300/333,
    marginRight: dimen(1)
  }
});

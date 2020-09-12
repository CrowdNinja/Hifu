import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
  SafeAreaView
} from 'react-native';
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronRight } from '@fortawesome/free-solid-svg-icons';

import ModalContact from '../common/modalCall'
import Indicator from '../common/indicator'

import {dimen, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import {ERR_DURATION} from '../../config/constant';

import * as Api from '../../apis/api'
import { UserContext, SET_PROFILE } from '../../store/store'
import {setStorage} from '../../config/storage'

const ICON_MSG = require('../../../assets/images/messg.png')
const IMG_TOP = require('../../../assets/images/info_top_bg.png');
const ICON_USER = require('../../../assets/images/icon_user.png');
const MENUS = [
  [require('../../../assets/images/icon_profile_person.png'), '個人情報', 'InfoScreen'],
  [require('../../../assets/images/icon_profile_security.png'), 'アカウント、セキュリティ', 'SecurityScreen'],
  [require('../../../assets/images/icon_profile_pay.png'), '支払い設定', 'PaymentPasswordScreen'],
  [require('../../../assets/images/icon_profile_cupon.png'), 'クーポン', 'CouponScreen'],
  [require('../../../assets/images/icon_profile_contact.png'), 'お問い合わせ', ''],
  [require('../../../assets/images/icon_profile_about.png'), '会社概要', 'AboutScreen'],
  [require('../../../assets/images/icon_tutorial.png'), '機器の使用方法', 'TutorialScreen'],
  // [require('../../../assets/images/icon_profile_shop.png'), '事業者登録', 'AdminStack'],
]

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      showModalContact: false,
      isImgNull: false,
      phone: '',
      loading: false,
    };
  }

  onLogout = () => {
    this.context.dispatch({type: SET_PROFILE})
    setStorage(null)
  }

  onCall = async () => {
    this.setState({loading: true})
    this.api_()
  }
  api_ = async () => {
    const response = await Api.about()
    
    this.setState({
      phone: response.phone,
      loading: false
    }, () => {
      setTimeout(() => this.setState({showModalContact: true}), ERR_DURATION)
    })
  }
  onClose = () => this.setState({showModalContact: false})

  render() {
    const {showModalContact, loading, isImgNull, phone} = this.state;
    const {nickname, avatar, account, money} = this.context.state

    return (
      <View style={{flex: 1, backgroundColor: colors.primaryColor}}>
      <SafeAreaView style={styles.wrapper}>
        {showModalContact &&
          <ModalContact
            phone={phone}
            onClose={this.onClose}
          />
        }
        {loading && <Indicator visible={loading} /> }

        <View style={styles.fullStyle}>
          <FastImage
            source={IMG_TOP}
            style={styles.backgroundImageStyle}
          > 
            <TouchableOpacity
              style={styles.onMenu}
              onPress={() => this.props.navigation.push('NewsScreen') }
            >
              <FastImage source={ICON_MSG} style={styles.messgBtnStyle} />
              {false &&
                <View style={styles.notifyStyle}>
                  <Text style={styles.notifyTextStyle}>1</Text>
                </View>
              }
            </TouchableOpacity>
            <View style={styles.headerTopStyle}>
              <View style={styles.block1_part1_header}>
                <View style={styles.part1_header}>
                  <FastImage 
                    key={avatar}
                    style={styles.avatar_part1_header}
                    source={isImgNull ? ICON_USER : {uri: avatar}}
                    onError={() => this.setState({isImgNull: true})}
                  />
                </View>

                <View style={{marginLeft: dimen(4)}}>
                  <Text style={styles.piece1_header}>{nickname}</Text>
                  <Text style={styles.piece2_header}>{account ? account.slice(0, 3)+"****" + account.slice(7): ''}</Text>
                  <Text style={styles.piece3_header}>チャージ残高: {money}</Text>
                </View>
              </View>

              <TouchableOpacity style={styles.piece4_header}
                onPress={() => this.props.navigation.push('ChargeScreen')}
              >
                <Text style={styles.text_piece4_header}>チャージ</Text>
              </TouchableOpacity>
            </View>
          </FastImage>
          
          <ScrollView contentContainerStyle={{flex: 1}}>
            {MENUS.map((menu, index) => {
              return (
                <TouchableOpacity key={index}
                  style={[styles.item, [0, 3].indexOf(index) > -1 ? {marginTop: dimen(2.5)} : {} ]}
                  onPress={() => index != 4 ? this.props.navigation.push(menu[2]) : this.onCall() }
                >
                  <View style={styles.item_sub}>
                    <FastImage 
                      style={styles.item_icon}
                      source={menu[0]}
                    />
                    <Text style={styles.item_text}>{menu[1]}</Text>
                  </View>
                  <FontAwesomeIcon icon={faChevronRight} color={'lightgray'} />
                </TouchableOpacity>
              )
            })}
          </ScrollView>

          <TouchableOpacity style={styles.logout_btn} onPress={this.onLogout}>
            <Text style={styles.logout_txt}>ログアウト</Text>
          </TouchableOpacity>
        </View>
      </SafeAreaView>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  wrapper: {
    flex: 1,
  },
  fullStyle: {
    flex: 1,
    position: 'relative',
    backgroundColor: colors.lightGrayColor
  },
  backgroundImageStyle: {
    height: SCREEN_HEIGHT * 0.2,
    paddingHorizontal: dimen(5),
    position: 'relative',
    justifyContent: 'center'
  },
  headerTopStyle: {
    flexDirection: "row",
    alignItems: 'flex-end',
    justifyContent: 'space-between',
  },
  part1_header: {
    shadowColor: 'gray',
    shadowOffset: {width: 5, height: 5},
    shadowOpacity: 0.7,
    shadowRadius: 10,
    elevation: 5,
    backgroundColor: 'transparent',
    borderRadius: dimen(10),
    zIndex: 100
  },
  avatar_part1_header: {
    backgroundColor: 'white',
    width: dimen(18),
    height: dimen(18),
    borderRadius: dimen(10),
  },
  block1_part1_header: {
    flexDirection: "row",
    alignItems: 'center',
  },
  piece1_header: {
    fontSize: dimen(4),
    color: colors.whiteColor
  },
  piece2_header: {
    fontSize: dimen(3),
    color: colors.whiteColor
  },
  piece3_header: {
    fontSize: dimen(4),
    color: colors.whiteColor,
    marginTop: dimen(2)
  },
  piece4_header: {
    paddingHorizontal: dimen(4),
    paddingVertical: dimen(1.5),
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(3.6),
  },
  text_piece4_header: {
    textAlign: "center",
    color: colors.primaryColor,
    textAlignVertical: "center",
    fontSize: dimen(3)
  },
  item: {
    height: dimen(11),
    backgroundColor: 'white',
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    paddingHorizontal: dimen(3.5),
    borderTopColor: 'lightgray',
    borderTopWidth: 0.3
  },
  item_sub: {
    flexDirection: "row",
    alignItems: "center",
  },
  item_icon: {
    width: dimen(5),
    height: dimen(5),
    resizeMode: 'cover'
  },
  item_text: {
    fontSize: dimen(3.5),
    marginLeft: dimen(2)
  },
  logout_btn: {
    position: 'absolute',
    bottom: dimen(5),
    left: dimen(4),
    right: dimen(4),
    backgroundColor: colors.primaryColor,
    borderRadius: dimen(6),
  },
  logout_txt: {
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(10),
    fontSize: dimen(5)
  },
  onMenu: {
    position: 'absolute',
    right: dimen(5),
    top: dimen(1),
    alignItems: 'center',
    justifyContent: 'center',
    alignSelf: 'flex-end',
  },
  messgBtnStyle: {
    width: dimen(8),
    height: dimen(8)
  },
  notifyStyle: {
    position: "absolute",
    borderRadius: dimen(1.6),
    width: dimen(3.2),
    height: dimen(3.2),
    backgroundColor: colors.redColor,
    right: dimen(0)
  },
  notifyTextStyle: {
    fontSize: dimen(3),
    color: colors.whiteColor,
    textAlign: "center"
  }
});

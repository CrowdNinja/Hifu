import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Image,
  Text,
  TouchableOpacity,
  ScrollView,
  ImageBackground,
} from 'react-native';
import FastImage from 'react-native-fast-image';
import moment from 'moment';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {dimen, percent} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

const ICON_SUBSC = require('../../../assets/images/icon_badge_subsc.png');
const IMG_MENU_PAY_BUTTON = require('../../../assets/images/menu_detail_button.png');
const IMG_POPUP_PAY = require('../../../assets/images/menu_detail_popup.png');
const ICON_DEFAULT = require('../../../assets/images/icon_category1.png');

export default class MenuDetailScreen extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);

    this.state = {
      loading: true,
      shop: null,
      pack: null,
      items: []
    };
  }

  componentDidMount() {
    this.api_get_pack_detail()
  }

  async api_get_pack_detail() {
    const {shop_id, pack_id} = this.props.route.params
    const result = await Api.get_pack_detail(shop_id, pack_id)

    this.setState({
      loading: false,
      shop: result[0], pack: result[1], items: result[2]
    })
  }

  goScreen = () => {
    const {account} = this.context.state;
    const {shop, pack} = this.state;

    if (account) {
      this.props.navigation.push("ReservationStack", {
        shopname: shop.nickname, shop_id: shop.shop_id, pack_id: pack.pack_id, isSubsc: pack.subscription_flg == 1
      })
    } else {
      this.props.navigation.navigate("TabMypage")
    }
  }

  render() {
    const {loading, shop, pack, items} = this.state;

    return (
      <View style={styles.container}>
        {loading && <Indicator/> }

        <TopBar
          title="メニュー詳細"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {!loading &&
          <>
            <ScrollView contentContainerStyle={styles.fullStyle}>
              <View style={styles.piece2_block1_part1}>
                <View style={[styles.border_bebel, {borderRadius: dimen(4)}]}>
                  <FastImage style={styles.image_piece1_block1_part1} source={{uri: shop.thumb}}/>
                </View>
                <Text style={styles.piece2_1_block1_part1}>{shop.nickname}</Text>
              </View>

              <CustomFastImage
                url={pack.img}
                style={styles.part1_image}
              />

              {pack.subscription_flg ? (
                <View style={styles.subc_header}>
                  <Text style={styles.subc_header_text}>{pack.title}</Text>
                  <FastImage style={styles.subc_header_img} source={ICON_SUBSC} />
                </View>
              ):(
                <>
                  <View style={styles.block2_part1}>
                    <Text style={styles.text1_block2_part1}>{pack.title}</Text>
                  </View>
                </>
              )}

              <Text style={styles.text_part3}>
                {pack.subscription_flg ? 'サブスクリプション / 定額制の詳細' : 'メニュー詳細'}
              </Text>
              
              {pack.subscription_flg ? (
                <View style={styles.sub_menu}>
                  <View style={[styles.subc_header, {paddingHorizontal: 0}]}>
                    <Text style={styles.subc_header_text}>チケット付与枚数</Text>
                    <View style={styles.subsc_header_rview}>
                      <Text style={styles.subc_header_text1}>{`1ヶ月${pack.count ?? 0}回通える`}</Text>
                      <View style={styles.subc_round}>
                        <Text style={styles.subc_header_text2}>{`毎月¥${pack.discount} OFF`}</Text>
                      </View>                      
                    </View>
                  </View>

                  {items.map((item, index) => {
                    return (
                      <View key={index} style={styles.part2}>
                        <View style={styles.subsc_item_head}>
                          <Text style={styles.text1_header_part2}>
                            {item.title}
                          </Text>
                          <View>
                            <Text style={styles.subc_txt_shot}>{item.knife}ショット</Text>
                            <Text style={styles.subc_txt_num}>{item.num}回</Text>
                          </View>
                        </View>
                        <View style={styles.subsc_item_body}>
                          <Text style={styles.text_block1_part2}>メニュー説明</Text>
                          <Text style={styles.service_block1_part2}>{item.text}</Text>
                        </View>
                      </View>
                    )
                  })}
                </View>
              ):(
                <View style={styles.sub_menu}>
                  {items.map((item, index) => {
                    return (
                      <View key={index}>
                        <View style={styles.part2}>
                          <Text style={styles.text1_header_part2} >
                            {item.title}
                          </Text>
                          <View style={styles.header_part2}>
                            <Text style={styles.text2_header_part2}>
                              {item.knife}ショット
                            </Text>
                            <Text style={[styles.text2_header_part2, {marginLeft: dimen(2.5)}]}>{item.num}回</Text>
                          </View>
                          <View style={styles.part4}>
                            <Text style={styles.service_block1_part2}>{pack.service_process}</Text>
                          </View>
                        </View>
                        {/* <ItemRow txtA="有効期限" txtB={moment(pack.validity_time).format('YYYY年M月D日 HH:mm')+'まで'} flex={true} /> */}
                        <ItemRow txtA="予約情報" txtB={pack.reservation_info} />
                        <ItemRow txtA="サービス内容" txtB={item.text} />
                      </View>
                    )
                  })}
                </View>
              )}
            </ScrollView>

            <View style={styles.footer}>
              <TouchableOpacity style={styles.right_button}
                onPress={this.goScreen}
              >
                {
                  pack.subscription_flg != 1 ? (
                    <Text style={styles.text_right_button1}>購入</Text>
                  ): (
                    <Image source={IMG_MENU_PAY_BUTTON} style={styles.text_right_button}/>
                  )
                }
              </TouchableOpacity>
              {pack.subscription_flg == 1 && (
                <ImageBackground source={IMG_POPUP_PAY} style={styles.popup}><Text style={styles.popup_txt_style1}>定額で購入すると</Text><Text style={styles.popup_txt_style2}>￥{pack.discount} OFF</Text><View style={styles.back_yellow_bar}></View></ImageBackground>
              )}
              <Text style={styles.price}>{pack.price}円</Text>
            </View>
          </>
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
        source={url ? {uri: url} : ICON_DEFAULT}
        style={style}
        onError={() => this.setState({url: null})}
        resizeMode={url ? 'cover' : 'contain'}
      />
    )
  }
}

const ItemRow = (props) => {
  const {txtA, txtB, flex} = props
  return (
    <View style={[styles.part4, flex? styles.flex: '']}>
      <Text style={[styles.text_block1_part2, !flex? styles.subsc_padding: '']}>{txtA}:</Text>
      <Text style={styles.service_block1_part2}>{txtB}</Text>
    </View>
  )
}

const styles = StyleSheet.create({
  flex: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between"
  },
  container: {
    flex: 1,
    backgroundColor: 'white'
  },
  fullStyle: {
    paddingBottom: dimen(12)
  },
  part1_image: {
    height: dimen(38),
    borderColor: 'lightgray',
    borderWidth: 0.3,
    margin: 0,
    padding: 0
  },
  border_bebel: {
    elevation: 1,
    shadowColor: 'black',
    backgroundColor: 'white',
    borderRadius: 10,
    shadowOffset: { width: 1, height: 1 },
    shadowOpacity: 0.3,
    shadowRadius: 1,
  },
  subsc_padding: {
    paddingBottom: dimen(5)
  },
  part1: {
    backgroundColor: colors.whiteColor,
    paddingVertical: dimen(3)
  },
  block3_part1: {
    flexDirection: "row",
    justifyContent: "center",
    alignItems: "center",
    borderBottomColor: colors.grayColor,
    borderBottomWidth: 1
  },
  text_piece1_block3_part1: {
    textAlign: "center",
    fontSize: dimen(5),
    paddingVertical: dimen(3)
  },
  text1_block2_part1: {
    fontSize: dimen(4),
    flexShrink: 1,
    fontWeight: "bold",
    paddingLeft: dimen(3)
  },
  text2_block2_part1: {
    fontSize: dimen(4),
  },
  part2: {
    // paddingVertical: dimen(4),
  },
  header_part2: {
    flexDirection: 'row',
    alignItems: 'center',
    fontSize: dimen(4),
    borderBottomColor: colors.grayColor,
    borderBottomWidth: 1,
    paddingVertical: dimen(3)
  },
  text1_header_part2: {
    fontSize: dimen(4),
    lineHeight: dimen(5),
    color: colors.blackColor,
    flexShrink: 1,
    paddingTop: dimen(3),
  },
  text2_header_part2: {
    backgroundColor: colors.primaryColor,
    color: 'white',
    lineHeight: dimen(6),
    paddingHorizontal: dimen(3),
    fontSize: dimen(3.5),
  },
  piece2_block1_part1: {
    flexDirection: "row",
    alignItems: 'center',
    padding: dimen(3),
  },
  image_piece1_block1_part1: {
    width: dimen(8),
    height: dimen(8),
    resizeMode: "cover",
    borderRadius: dimen(4),
    backgroundColor: colors.primaryColor,
  },
  piece2_1_block1_part1: {
    marginLeft: dimen(4),
    fontSize: dimen(4.5)
  },
  block2_part1: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    paddingVertical: dimen(3)
  },
  text_block1_part2: {
    fontSize: dimen(3.8),
    fontWeight: 'bold',
    lineHeight: dimen(5),
  },
  service_block1_part2: {
    fontSize: dimen(3.5),
    lineHeight: dimen(4.5),
    color: colors.blackColor
  },
  text_part3: {
    fontSize: dimen(3.5),
    color: colors.textColor,
    backgroundColor: '#F8F8F8',
    paddingLeft: dimen(3),
    paddingTop: dimen(2.5),
    paddingBottom: dimen(0.5)
  },
  sub_menu: {
    paddingHorizontal: dimen(3),
    marginBottom: dimen(10)
  },
  part4 :{
    paddingVertical: dimen(3),
    borderTopWidth: 0.5,
    borderColor: 'lightgray'
  },
  footer: {
    backgroundColor: 'white',
    position: "absolute",
    bottom: 0,
    left: 0,
    right: 0,
    flexDirection: 'row-reverse',
    alignItems: 'center',
    padding: dimen(3),
    borderTopColor:colors.gray230,
    borderTopWidth: 1,
    position: "relative"
  },
  price: {
    color: colors.textRed,
    fontSize: dimen(6),
    marginRight: 20,
    fontWeight: "bold"
  },
  right_button: {
    backgroundColor: colors.primaryColor,
    color: colors.whiteColor,
    width: dimen(27),
    height: dimen(9),
    borderRadius: dimen(4.5),
  },
  text_right_button: {
    width: percent(100),
    height: percent(100),
    resizeMode: "cover"
  },
  text_right_button1: {
    fontSize: dimen(4),
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(9),
  },
  subc_header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginVertical: dimen(2),
    paddingHorizontal: dimen(3)
  },
  subc_header_text: {
    fontSize: dimen(4),
    fontWeight: 'bold',
    flexShrink: 1,
    color: colors.blackColor,
  },
  subc_header_text1: {
    fontSize: dimen(4.2),
    fontWeight: 'bold',
    textAlign: 'right'
  },
  subc_header_text2: {
    fontSize: dimen(3.5),
    fontWeight: 'bold',
    textAlign: 'right',
    color: 'white'
  },
  subc_header_img: {
    width: dimen(35),
    height: dimen(8.8),
    resizeMode: "contain"
  },
  subsc_header_rview: {
  },
  subc_round: {
    paddingHorizontal: 5,
    backgroundColor: '#CB4176',
    borderRadius: 20,
  },
  subc_txt_shot: {
    textAlign: 'right',
    fontSize: dimen(3.5)
  },
  subc_txt_num: {
    textAlign: 'right',
    fontSize: dimen(3),
    color: 'gray'
  },
  subsc_item_head: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    borderTopWidth: 0.5,
    borderBottomWidth: 0.5,
    borderTopColor: 'lightgray',
    borderBottomColor: 'lightgray',
    paddingVertical: dimen(2)
  },
  subsc_item_body: {
    paddingVertical: dimen(3),
    borderBottomWidth: 0.5,
    borderBottomColor: 'lightgray'
  },
  popup: {
    width: dimen(35),
    height: dimen(14.8),
    resizeMode: "contain",
    position: "absolute",
    bottom: percent(140),
    marginRight: dimen(3)
  },
  popup_txt_style1: {
    textAlign: "center",
    fontSize: dimen(3.5),
    fontWeight: "bold",
    marginTop: dimen(2)
  },
  popup_txt_style2: {
    textAlign: "center",
    fontSize: dimen(4),
    fontWeight: "bold",
    zIndex: 2
  },
  back_yellow_bar: {
    position: "absolute",
    height: dimen(2),
    backgroundColor: '#fcf41d',
    width: dimen(30),
    left: dimen(2.5),
    bottom: dimen(4.5),
    zIndex: 0
  }
});
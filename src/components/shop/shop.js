import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  Alert,
  FlatList,
  Linking,
  Platform
} from 'react-native';
import moment from 'moment';
import FastImage from 'react-native-fast-image'
import {AirbnbRating} from 'react-native-ratings';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronDown, faChevronUp, faMapMarkerAlt } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ItemShop from './_item_shop'

import {ERR_DURATION, ERR_MSG} from '../../config/constant'
import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      loading: true,
      shop_id: props.route.params.shop_id,
      favorite: false,
      shop: null
    };
  }

  componentDidMount() {
    this.api_get_shop()
  }

  openMap = () => {
    const {shop} = this.state
    const {lat, lng} = shop
    if (Platform.OS === 'ios')
      Linking.openURL(`http://maps.apple.com/?ll=${lat},${lng}`)
    else
      Linking.openURL(`geo:${lat},${lng}`)
  }

  goShop = () => this.props.navigation.push("ShopDetail", {shop_id: this.state.shop_id})

  async api_get_shop() {
    const {token, shop_id} = this.state
    const response = await Api.get_shop_detail(shop_id, token)

    if (response) {
      this.setState({loading: false, shop: response[0], favorite: response[1] == 1})
    } else {
      this.setState({loading: false}, () => {
        setTimeout(() => {
          Alert.alert(ERR_MSG)
        }, ERR_DURATION)
      })
    }
  }

  render() {
    const {loading, shop, favorite} = this.state;

    return (
      <View style={styles.container}>
        {loading && <Indicator/> }

        <TopBar
          title={!shop ? "" : shop.nickname}
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {shop &&
          <>
          <FlatList
            data={shop.reviews}
            initialNumToRender={10}
            renderItem={({item, index}) =>
              <PreviewComponent key={index} review={item} />
            }
            keyExtractor={(_, index) => `${index}`}
            showsVerticalScrollIndicator={false}
            style={{flex: 1}}
            ListHeaderComponent={
              <>
                <View style={styles.container_style}>
                  <ItemShop
                    shop={shop}
                    navigation={this.props.navigation}
                    favorite={favorite}
                  />
                </View>
                <View style={styles.space_bar} ></View>
                <View style={styles.container_style}>
                  <View style={styles.part2}>
                    {/* <TouchableOpacity style={styles.header_part2}
                      onPress={() => this.props.navigation.push("ShopIntroductionScreen", {content: shop.text})}
                    >
                      <Text style={styles.text1_header_part2} numberOfLines={1}>
                        店舗紹介へ
                      </Text>
                      <FontAwesomeIcon icon={faChevronRight} color='gray'/>
                    </TouchableOpacity> */}

                    <Text style={styles.text_block1_part2}>レビュー（{shop.total_count}）</Text>
                    <View style={styles.block2_part2}>
                      <Text style={styles.piece1_block2_part2}>{shop.score}</Text>
                      <View style={styles.piece2_block2_part2}>
                        <Text style={styles.text1_piece2_block2_part2}>総合評価</Text>
                        <View style={styles.content_piece2_block2_part2}>
                          <AirbnbRating count={5} defaultRating={shop.score} size={dimen(4)} isDisabled={true} showRating={false} />
                          <Text style={styles.text_piece2_2_block1_part2} ></Text>
                        </View>
                      </View>
                      <Text style={styles.text2_piece2_block2_part2}>高評価率 {shop.praise_ratio} ％</Text>
                    </View>
                  </View>
                </View>
              </>
            }
          />
          <View style={styles.btn_group}>
            <TouchableOpacity style={[styles.btn_bottom, styles.btn_map]}
              onPress={this.openMap}
            >
              <FontAwesomeIcon size={dimen(4)} icon={faMapMarkerAlt} color={'white'} />
              <Text style={[styles.txt_btn_bottom, {marginLeft: dimen(1.5)}]}>アクセス</Text>
            </TouchableOpacity>
            <TouchableOpacity style={[styles.btn_bottom, styles.btn_shop]}
              onPress={this.goShop}
            >
              <Text style={styles.txt_btn_bottom}>店舗情報を見る</Text>
            </TouchableOpacity>
          </View>
          </>
        }
      </View>
    );
  }
}

class PreviewComponent extends PureComponent {
  constructor(props) {
    super(props)

    this.state = {
      flagFull: false
    }
  }

  render() {
    const {flagFull} = this.state
    const review = this.props.review

    return (
      <View style={styles.preview_part2}>
        <View style={styles.content_preview_part2}>
          <FastImage style={styles.icon_block2_part2} source={{uri: review.avatar}} />
          <View style={styles.piece2_block2_part2}>
            <Text style={[styles.text1_piece2_block2_part2, styles.text1_preview]}>{review.nickname}</Text>
            <View style={[styles.content_piece2_block2_part2, styles.content_preview]}>
              <AirbnbRating count={5}
                defaultRating={review.score} size={dimen(3.5)} isDisabled={true} showRating={false}
              />
            </View>
          </View>
          <Text style={styles.text2_piece2_block2_part2}>{moment(review.ctime).format('M月D日')}</Text>
        </View>
        <Text style={styles.text_preview_part2} numberOfLines={flagFull ? 0 : 1}>
          {review.content}
        </Text>
        <TouchableOpacity style={styles.view_more}
          onPress={() => this.setState({flagFull: !flagFull})}
        >
          <Text style={styles.full_text_button}>もっと見る</Text>
          <FontAwesomeIcon color='gray'
            size={dimen(3.5)}
            style={{marginBottom: 2}}
            icon={flagFull ? faChevronUp : faChevronDown}
          />
        </TouchableOpacity>
        {review.imgs.length > 0 &&
          <View style={styles.images_wrapper_preview}>
            {review.imgs.map((img, index) => {
              return (
                <FastImage key={index} source={{uri: img}} style={styles.image_preview} />
              )
            })}
          </View>
        }
      </View>
    )
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.whiteColor,
  },
  container_style: {
    padding: dimen(3)
  },
  content: {
    paddingVertical: dimen(3),
  },
  space_bar: {
    width: percent(100),
    height: dimen(4),
    marginVertical: dimen(3),
    backgroundColor: colors.lightGrayColor
  },
  part2: {
  },
  header_part2: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: 'space-between',
    paddingBottom: dimen(4),
    borderBottomColor: colors.grayColor,
    borderBottomWidth: 1
  },
  text1_header_part2: {
    fontSize: dimen(4),
    paddingRight: 30,
    width: dimen(75)
  },
  block2_part2: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "flex-end",
    width: percent(100),
    paddingBottom: dimen(2),
    borderBottomWidth: 1,
    borderBottomColor: colors.grayColor
  },
  content_preview_part2:{
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
  },
  piece1_block2_part2: {
    fontSize: dimen(6),
    fontWeight: "bold",
  },
  text_preview_part2: {
    fontSize: dimen(3.5),
    paddingVertical: dimen(3),
  },
  full_text_button: {
    fontSize: dimen(3.5),
    textAlign: 'left',
    color: colors.block2_part2
  },
  images_wrapper_preview: {
    flexDirection: "row",
    alignItems: "center",
    padding: dimen(3),
    paddingBottom: 0
  },
  image_preview: {
    width: dimen(20),
    height: dimen(17),
    borderRadius: 8,
    borderWidth: 0.3,
    borderColor: 'lightgray',
    marginRight: dimen(5)
  },
  piece2_block2_part2:{
    flex: 1,
    textAlign: "left",
    paddingLeft: dimen(2),
  },
  text1_preview: {
    fontSize: dimen(4),
    color: colors.textColor,
    paddingLeft: 0
  },
  content_piece2_block2_part2:{
    flex: 1,
    flexDirection: "row",
    width: percent(100),
    alignItems: "center",
    textAlign: "left",
  },
  content_preview: {
    paddingVertical: 0,
    paddingHorizontal: 0
  },
  text_block1_part2: {
    fontSize: dimen(5),
    paddingBottom: dimen(4)
  },
  text1_piece2_block2_part2:{
    paddingLeft: dimen(4),
    fontSize: dimen(4),
  },
  text2_piece2_block2_part2: {
    fontSize: dimen(3.5),
    paddingBottom: dimen(1.5),
    color: colors.textColor
  },
  icon_block2_part2: {
    width: dimen(12),
    height: dimen(12),
    borderRadius: dimen(10),
    borderWidth: 0.2,
    borderColor: 'lightgray'
  },
  preview_part2: {
    paddingHorizontal: dimen(3),
    paddingVertical: dimen(2.5),
    borderBottomWidth: 0.6,
    borderBottomColor: 'lightgray'
  },
  view_more: {
    flexDirection: 'row',
    alignItems: 'center',
    alignSelf: 'center'
  },
  btn_group: {
    flexDirection: 'row',
    alignItems: 'center',
    margin: dimen(3)
  },
  btn_bottom: {
    height: dimen(11),
    borderRadius: dimen(1),
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center'
  },
  btn_shop: {
    flex: 1,
    backgroundColor: colors.primaryColor
  },
  btn_map: {
    backgroundColor: '#667680',
    marginRight: dimen(3),
    paddingHorizontal: dimen(4)
  },
  txt_btn_bottom: {
    fontSize: dimen(4),
    fontWeight: 'bold',
    color: 'white'
  }
});
import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  Alert,
  Linking,
  Platform
} from 'react-native';
import { connect } from 'react-redux'
import _ from 'lodash';
import FastImage from 'react-native-fast-image'
import {AirbnbRating} from 'react-native-ratings';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronDown, faChevronUp, faMapMarkerAlt, faClock, faPhoneAlt, faHeart } from '@fortawesome/free-solid-svg-icons';
import {
  MaterialIndicator
} from 'react-native-indicators';

import ItemMenu from './_item_menu'
import ModalContact from '../common/modalCall'

import {
  fetchBookmark
} from '../../actions'
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

class App extends React.PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props)

    this.state = {
      isDroped: false,
      mode: props.mode,
      showDlgContact: false,
      favorite: props.favorite,
    }
  }

  componentDidUpdate(prevProps) {
    const {favorite, mode} = this.state
    if (this.props.favorite != favorite && mode == 2) {
      this.setState({favorite: this.props.favorite})
    }
  }

  onLike = (flag) => () => {
    const {token} = this.context.state
    if (!token) {
      Alert.alert('ユーザーログインしてください。')
      return
    }

    const {bookmarks} = this.props.userReducer
    const shop_id = this.props.shop.shop_id

    this.props.fetchBookmark(token, bookmarks, shop_id, flag)
  }
  onClose = () => {
    this.setState({showDlgContact: false})
  }
  goShop = (shop_id) => () => {
    this.props.navigation.navigate("ShopStack", {
      screen: 'ShopScreen',
      params: {
        shop_id: shop_id
      }
    })
  }
  openMap = () => {
    const {shop} = this.props
    const {lat, lng} = shop
    if (Platform.OS === 'ios')
      Linking.openURL(`http://maps.apple.com/?ll=${lat},${lng}`)
    else
      Linking.openURL(`geo:${lat},${lng}`)
  }

  renderType1 = () => {
    const {shop} = this.props

    const {bookmarks, fetchingBookmark} = this.props.userReducer
    const favorite = bookmarks.indexOf(shop.shop_id) > -1

    return (
      <>
        <View style={styles.piece2_block1_part1}>
          <View style={styles.piece2_block1_part2}>
            <Text style={styles.piece2_1_block1_part1}>{shop.nickname}</Text>
            <View style={styles.piece2_2_block1_part1}>
              <View style={styles.piece2_2_block1_part1}>
                <AirbnbRating count={5} defaultRating={shop.score} size={dimen(4)} isDisabled={true} showRating={false} ></AirbnbRating>
                <Text style={styles.text_piece2_2_block1_part1} >{shop.score}</Text>
              </View>
              <TouchableOpacity style={[styles.map, {marginLeft: dimen(3)}]}
                onPress={this.openMap}
              >
                <FontAwesomeIcon icon={faMapMarkerAlt} color={colors.green} size={dimen(3.2)} />
                <Text style={styles.txt_map}>MAP</Text>
              </TouchableOpacity>
            </View>
          </View>
          <TouchableOpacity onPress={this.onLike(!favorite)} >
            {fetchingBookmark ? (
              <MaterialIndicator color='gray' size={15}/>
            ): (
              this.context.state.token && 
                <FontAwesomeIcon icon={faHeart} color={favorite ? 'red' : 'lightgray'} size={dimen(7)} />
            )}
          </TouchableOpacity>
        </View>

        <View style={[styles.border_bebel,{marginTop: dimen(2)}]}>
          <FastImage
            source={{uri: shop.thumb}}
            style={styles.part1_image}
          />
        </View>

        <View style={styles.block3_part1}>
          <View style={styles.piece1_block3_part1}>
            <View style={styles.sub_part_phone}>
              <FontAwesomeIcon size={dimen(4)} icon={faMapMarkerAlt} color={'lightgray'} />
              <Text style={styles.text_piece1_block3_part1}>{shop.address}</Text>
            </View>
            <View style={styles.sub_part_phone}>
              <FontAwesomeIcon size={dimen(4)} icon={faClock} color={'lightgray'} />
              <Text style={styles.text_piece1_block3_part1}>{shop.hours}</Text>
            </View>
          </View>
          <TouchableOpacity style={styles.piece2_block3_part1} onPress={() => this.setState({showDlgContact: true})}>
            <FontAwesomeIcon size={dimen(5)} icon={faPhoneAlt} color={'lightgray'} />
          </TouchableOpacity>
        </View>
      </>
    )
  }
  renderType2 = () => {
    const {shop} = this.props
    const {bookmarks, fetchingBookmark} = this.props.userReducer
    const favorite = bookmarks.indexOf(shop.shop_id) > -1

    return (
      <TouchableOpacity
        onPress={this.goShop(shop.shop_id)}
      >
        <View style={styles.block1_part2}>
          <View style={styles.piece2_block1_part2}>
            <Text style={styles.piece2_1_block1_part2}>{shop.nickname}</Text>
            <View style={styles.piece2_2_block1_part2}>
              <AirbnbRating count={5} defaultRating={shop.score} size={dimen(4)} isDisabled={true} showRating={false} style={styles.rating_piece2_2_block1_part2} ></AirbnbRating>
              <Text style={styles.text_piece2_2_block1_part2} >{shop.score}</Text>
              <Text style={styles.piece3_block1_part2}>{shop.keywords}</Text>
              <Text style={styles.piece3_block1_part2}>
                <FontAwesomeIcon icon={faMapMarkerAlt} size={dimen(3)} color={colors.gray170} />
                {shop.distance}
              </Text>
            </View>
          </View>
          <TouchableOpacity onPress={this.onLike(!favorite)} style={styles.view_icon_fav}>
            {fetchingBookmark ? (
              <MaterialIndicator color='gray' size={15}/>
            ): (
              this.context.state.token &&  <FontAwesomeIcon icon={faHeart} color={favorite ? 'red' : 'lightgray'} size={dimen(7)} />
            )}
          </TouchableOpacity>
        </View>
        <View style={[styles.border_bebel, styles.img_shop]}>
          <FastImage
            source={{uri: shop.thumb}}
            style={styles.part1_image}
          />
        </View>
      </TouchableOpacity>
    )
  }
  renderType3 = () => {
    const {shop} = this.props
    const {fetchingBookmark} = this.props.userReducer
    const {favorite} = this.state

    return (
      <TouchableOpacity style={styles.item_type3}
        onPress={this.goShop(shop.shop_id)}
      >
        <View style={styles.piece2_block1_part1}>
          <View style={styles.piece2_block1_part2}>
            <Text style={styles.piece2_1_block1_part1}>{shop.nickname}</Text>
            <View style={styles.piece2_2_block1_part1}>
              <AirbnbRating count={5} defaultRating={shop.score} size={16} isDisabled={true} showRating={false} ></AirbnbRating>
              <Text style={styles.text_piece2_2_block1_part2} >{shop.score}</Text>
              <Text style={styles.piece3_block1_part2}>{shop.keywords}</Text>
              <Text style={styles.piece3_block1_part2}><FontAwesomeIcon icon={faMapMarkerAlt} size={10} color={colors.gray170} />{shop.distance}</Text>
            </View>
          </View>
          <TouchableOpacity onPress={this.onLike(!favorite)} style={styles.view_icon_fav}>
            {fetchingBookmark ? (
              <MaterialIndicator color='gray' size={15}/>
            ): (
              <FontAwesomeIcon icon={faHeart} color={favorite ? 'red' : 'lightgray'} size={dimen(7)} />
            )}
          </TouchableOpacity>
        </View>
        
        <View
          style={[styles.border_bebel, styles.img_shop]}
        >
          <FastImage
            source={{uri: shop.thumb}}
            style={styles.part1_image}
          />
        </View>
      </TouchableOpacity>
    )
  }
  renderType4 = () => {
    const {shop} = this.props

    const {bookmarks, fetchingBookmark} = this.props.userReducer
    const favorite = bookmarks.indexOf(shop.shop_id) > -1

    return (
      <>
        <View style={styles.piece2_block1_part1}>
          <View style={styles.piece2_block1_part2}>
            <Text style={styles.piece2_1_block1_part1}>{shop.nickname}</Text>
            <View style={styles.piece2_2_block1_part1}>
              <View style={styles.piece2_2_block1_part1}>
                <AirbnbRating count={5} defaultRating={shop.score} size={dimen(4)} isDisabled={true} showRating={false} ></AirbnbRating>
                <Text style={styles.text_piece2_2_block1_part1} >{shop.score}</Text>
              </View>
              <TouchableOpacity style={[styles.map, {marginLeft: dimen(3)}]}
                onPress={this.openMap}
              >
                <FontAwesomeIcon icon={faMapMarkerAlt} color={colors.green} size={dimen(3.2)} />
                <Text style={styles.txt_map}>MAP</Text>
              </TouchableOpacity>
            </View>
          </View>
          <TouchableOpacity onPress={this.onLike(!favorite)} >
            {fetchingBookmark ? (
              <MaterialIndicator color='gray' size={15}/>
            ): (
              this.context.state.token && 
                <FontAwesomeIcon icon={faHeart} color={favorite ? 'red' : 'lightgray'} size={dimen(7)} />
            )}
          </TouchableOpacity>
        </View>

        <View style={[styles.border_bebel,{marginTop: dimen(2)}]}>
          <FastImage
            source={{uri: shop.thumb}}
            style={styles.part1_image}
          />
        </View>
      </>
    )
  }
  render() {
    const {shop, navigation} = this.props
    const {isDroped, mode, showDlgContact} = this.state

    const cntLimit = mode == 2 ? 0 : 3

    var style_ = styles.container
    if (mode == 1) style_ = styles.body_part2
    else if (mode == 2) style_ = [styles.container_fav, styles.border_bebel]
    return(
      <View style={style_}>
        {mode == 0 && this.renderType1() }
        {mode == 1 && this.renderType2() }
        {mode == 2 && this.renderType3() }
        {mode == 3 && this.renderType4() }
        {mode != 3 &&
          <>
            {shop.packs.slice(0, isDroped ? shop.packs.length : cntLimit ).map((pack, index) => {
              return (
                <ItemMenu key={index}
                  navigation={navigation}
                  shop_id={shop.shop_id}
                  pack={pack}
                  mode={mode}
                />
              )
            })}

            {shop.packs.length > cntLimit &&
              <TouchableOpacity style={styles.more_view}
                onPress={() => this.setState({isDroped: !isDroped}) }>
                <Text style={{fontSize: dimen(3.5)}}>
                  {mode == 2 ? 'メニューを見る' : 'より多くの商品を見る'}
                </Text>
                <FontAwesomeIcon color='gray'
                  size={dimen(3.5)}
                  style={{marginBottom: 2}}
                  icon={isDroped ? faChevronUp : faChevronDown}
                />
              </TouchableOpacity>
            }
          </>
        }

        {showDlgContact &&
          <ModalContact visible={showDlgContact} phone={shop.phone}
            onClose={this.onClose}
          />
        }
      </View>
    )
  }
}

App.defaultProps = {
  mode: 0,
  favorite: false
};

function mapStateToProps (state) {
  return {
    userReducer: state.userReducer,
  }
}
function mapDispatchToProps (dispatch) {
  return {
    fetchBookmark: (token, ids, id, flag) => dispatch(fetchBookmark(token, ids, id, flag)),
  }
}
export default connect(
  mapStateToProps,
  mapDispatchToProps
)(App)

const styles = StyleSheet.create({
  container: {
    position: 'relative',
  },
  border_bebel: {
    elevation: 1,
    backgroundColor: 'white',
    shadowColor: 'black',
    borderRadius: 4,
    borderWidth: 0.3,
    borderColor: 'lightgray',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
    elevation: 2
  },
  body_part2: {
    position: 'relative',
    marginVertical: dimen(2),
    paddingHorizontal: dimen(2),
    paddingBottom: dimen(3),
    borderRadius: 3,
    borderWidth: 0.3,
    borderRadius: 6,
    borderColor: colors.gray230,
    marginHorizontal: dimen(3),
    padding: dimen(3),
    shadowColor: 'black',
    backgroundColor: colors.whiteColor,
    shadowOffset: { width: 0, height: 0 },
    shadowOpacity: 0.2,
    shadowRadius: 1,
    elevation: 2
  },
  container_fav: {
    margin: dimen(3),
    padding: dimen(3),
    borderRadius: 5,
    backgroundColor: 'white'
  },
  block1_part2: {
    flexDirection: "row",
    alignItems: 'center',
  },
  piece2_block1_part2: {
    flex: 1,
  },
  piece2_1_block1_part2: {
    fontSize: dimen(4.5),
    fontWeight: "bold",
    flexShrink: 1
  },
  piece2_2_block1_part2: {
    flexDirection: "row",
    alignItems: "center"
  },
  text_piece2_2_block1_part2: {
    fontSize: dimen(3.5)
  },
  piece2_3_block1_part2: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: 'space-between'
  },
  piece3_block1_part2: {
    color: colors.textColor,
    fontSize: dimen(3.5),
    marginLeft: dimen(3)
  },
  more_view: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: 'center',
    paddingTop: dimen(3)
  },
// MODE 1
  part1_image: {
    width: percent(100),
    height: dimen(40),
    backgroundColor: 'white',
    borderRadius: 4,
    borderWidth: 0.3,
    borderColor: 'lightgray',
    resizeMode: "cover"
  },
  block3_part1: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    marginVertical: dimen(4)
  },
  piece1_block3_part1: {
    borderRightColor: 'lightgray',
    borderRightWidth: 0.5,
    flex: 1,
  },
  sub_part_phone: {
    flexDirection: 'row',
    alignItems: 'center',
    marginVertical: 5
  },
  piece2_block3_part1: {
    paddingHorizontal: dimen(7),
    paddingVertical: 5
  },
  text_piece1_block3_part1: {
    flexShrink: 1,
    fontSize: dimen(4),
    paddingLeft: 8
  },
  piece2_1_block1_part1: {
    fontSize: dimen(4.5),
    fontWeight: "bold",
    color: colors.blackColor,
    marginBottom: dimen(0.5)
  },
  piece2_2_block1_part1: {
    flexDirection: "row",
    alignItems: "center",
  },
  text_piece2_2_block1_part1: {
    fontSize: dimen(3.5)
  },
  piece2_3_block1_part1: {
    color: colors.textColor
  },
  piece3_block1_part1: {
    color: colors.textColor,
    fontSize: dimen(3.5)
  },
  piece2_block1_part1: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: 'space-between',
  },
  view_icon_fav: {
    width: dimen(7),
    height: dimen(7)
  },
  item_type3: {
    paddingBottom: dimen(1),
    borderBottomColor: 'lightgray',
    borderBottomWidth: 0.4
  },
  img_shop: {
    width: '60%',
    alignSelf: 'center',
    marginVertical: dimen(2)
  },
  map: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: dimen(1),
    paddingVertical: dimen(0.5),
    borderRadius: dimen(1),
    borderWidth: 1,
    borderColor: 'lightgray',
  },
  txt_map: {
    fontSize: dimen(3.2),
    fontWeight: 'bold',
    color: colors.green
  }
});
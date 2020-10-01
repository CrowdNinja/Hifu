import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  FlatList,
  RefreshControl
} from 'react-native';
import { connect } from 'react-redux'
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faSortDown, faSearch } from '@fortawesome/free-solid-svg-icons';

import ItemShop from '../shop/_item_shop'

import { dimen } from '../../config/dimen';
import colors from '../../config/colors';

import {
  fetchShop,
  fetchSearchShop,
  fetchBookmark
} from '../../actions'
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

const ICON_USER = require('../../../assets/images/icon_user.png');
const ICON_QR = require('../../../assets/images/icon_qr.png');
const IMG_CATEGORIES = [
  require('../../../assets/images/icon_category1.png'),
  require('../../../assets/images/icon_category2.png'),
  require('../../../assets/images/icon_category3.png'),
]

class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      img: null,
      loading: true,
      city: context.state.city,
      showAgree: true,
      showTutorial: true,
    };
  }

  async componentDidMount() {
    const data = await Api.get_img()
    this.setState({loading: false, img: data.img[0]})
  }

  onClickAgree = (isAgreed) => this.setState({showAgree: false})
  onClickTutorial = () => this.setState({showTutorial: false})

  goScreen = (kind = null) => () => {
    if (kind) {
      if (kind == 1) {
        this.props.navigation.navigate("SearchAreaScreen")
      } else {
        this.props.navigation.navigate("ShopStack", {
          screen: 'SearchKeywordScreen',
        })  
      }
    } else {
      this.props.navigation.navigate("TabMypage")
    }
  }

  onRefresh = (isSearch = false) => {
    this.setState({loading: true})
    this.api_get_shops(isSearch)
  }

  async api_get_shops(isSearch = false) {
    const {longitude, latitude, token, city} = this.context.state

    if (token) this.props.fetchBookmark(token)

    if (!isSearch) {
      this.props.fetchShop(latitude, longitude)
      this.setState({loading: false})
    } else {
      this.props.fetchSearchShop(latitude, longitude, city)
      this.setState({loading: false, city})
    }
  }

  render() {
    const {
      loading, city, showAgree, showTutorial, img
    } = this.state;
    const {navigation} = this.props
    const {shops, fetchingShop} = this.props.shopReducer
    const {searchShops} = this.props.searchReducer
    const {fetchingBookmark} = this.props.userReducer

    var isLoading = loading
    if (city != this.context.state.city) {
      isLoading = true
      this.onRefresh(true)
    }

    return (
      <View style={styles.fullStyle}>
        <FlatList
          refreshControl={
            <RefreshControl
              refreshing={isLoading || fetchingShop || fetchingBookmark}
              onRefresh={this.onRefresh}
              tintColor='gray'
            />
          }
          data={city ? searchShops : shops}
          initialNumToRender={10}
          renderItem={({item, index}) =>
            <ItemShop
              key={index}
              index={index}
              mode={1}
              shop={item}
              navigation={this.props.navigation}
            />
          }
          keyExtractor={(_, index) => `${index}`}
          contentInset={{ bottom: 30 }}
          ListHeaderComponent={
            !isLoading &&
            <>
              <FastImage
                source={{uri: img}}
                style={styles.part1_image}
              />

              <View style={styles.part1}>
                <View style={styles.search_part}>
                  <View style={[styles.search_box, styles.border_bebel]}>
                    <View style={styles.search_box_left}>
                      <TouchableOpacity onPress={this.goScreen}>
                        <FastImage source={ICON_USER} style={styles.img_user} />
                      </TouchableOpacity>

                      <TouchableOpacity style={styles.piece2_block1_part1}
                        onPress={this.goScreen(1)}
                      >
                        <Text style={styles.txt_area}>
                          {city ?? '現在地'}
                        </Text>
                        <FontAwesomeIcon size={dimen(4)} icon={faSortDown} style={styles.fontawesome_down} />
                      </TouchableOpacity>
                    </View>

                    <TouchableOpacity style={styles.search_box_right}
                      onPress={this.goScreen(2)}
                    >
                      <FontAwesomeIcon size={dimen(4)} icon={faSearch} color={'lightgray'} />
                      <Text style={styles.search_input}>わたしのアプリ</Text>
                    </TouchableOpacity>
                  </View>

                  <TouchableOpacity style={[styles.qr_box, styles.border_bebel]}
                    onPress={() => navigation.navigate("QRScreen") }
                  >
                    <FastImage source={ICON_QR} style={styles.img_qr} />
                  </TouchableOpacity>
                </View>
                

                <View style={styles.category_box}>
                  {IMG_CATEGORIES.slice(0, 1).map((imgCategory, index) => {
                    return (
                      <TouchableOpacity key={index} style={styles.category_item}
                        onPress={() => this.props.navigation.navigate("ShopStack", {
                          screen: 'SearchResultScreen',
                          params: {
                          }
                        })}
                      >
                        <FastImage source={imgCategory} style={styles.img_category}
                          resizeMode={FastImage.resizeMode.contain} />
                      </TouchableOpacity>
                    )
                  })}
                </View>
              </View> 
              
              <View style={styles.header_part2}>
                <Text style={styles.text_header_part2}>店舗紹介</Text>
              </View>
            </>
          }
        />
      </View>
    );
  }
}

function mapStateToProps (state) {
  return {
    userReducer: state.userReducer,
    searchReducer: state.searchReducer,
    shopReducer: state.shopReducer
  }
}
function mapDispatchToProps (dispatch) {
  return {
    fetchShop: (lat, lng) => dispatch(fetchShop(lat, lng)),
    fetchSearchShop: (lat, lng, city) => dispatch(fetchSearchShop(lat, lng, city)),
    fetchBookmark: (token) => dispatch(fetchBookmark(token)),
  }
}
export default connect(
  mapStateToProps,
  mapDispatchToProps
)(App)

const styles = StyleSheet.create({
  wrapper: {},
  fullStyle: {
    flex: 1,
    backgroundColor: 'white',
    position: 'relative'
  },
  part1:{
    marginTop: dimen(-6)
  },
  part1_image: {
    width: dimen(100),
    height: undefined,
    aspectRatio: 750/530
  },
  border_bebel: {
    shadowColor: 'gray',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
    backgroundColor: 'white',
    elevation: 4,
    borderWidth: 0.3,
    borderColor: 'lightgray'
  },
  search_part: {
    flexDirection: "row",
    alignItems: "center",
    marginHorizontal: dimen(4),
  },
  search_box: {
    flex: 1,
    flexDirection: "row",
    alignItems: "center",
    height: dimen(12),
    padding: dimen(2),
    borderRadius: dimen(6),
    marginRight: dimen(4)
  },
  qr_box: {
    width: dimen(12),
    height: dimen(12),
    borderRadius: dimen(6),
    alignItems: 'center',
    justifyContent: 'center',
  
  },
  img_qr: {
    width: dimen(6),
    height: dimen(6),
  },
  search_box_left: {
    flexDirection: 'row',
    alignItems: 'center',
    borderRightWidth: 1,
    borderRightColor: 'lightgray',
    paddingRight: 5
  },
    img_user: {
      width: dimen(9),
      height: dimen(9),
      borderRadius: dimen(4.5),
    },
    piece2_block1_part1: {
      flexDirection: 'row',
      alignItems: 'center',
    },
    txt_area: {
      marginHorizontal: 10,
      fontSize: dimen(3.5)
    },
    fontawesome_down: {
      marginBottom: dimen(2)
    },
  search_box_right: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingLeft: 8
  },
    search_input: {
      flex: 1,
      marginLeft: 8,
      color: 'lightgray',
      fontSize: dimen(4)
    },
  category_box: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    marginVertical: 15,
  },
  category_item: {
    marginHorizontal: 10,
    padding: 5,
    borderRadius: 5,
    borderWidth: 0.5,
    borderColor: 'lightgray',
    backgroundColor: 'white',
    shadowColor: 'gray',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
    elevation: 2
  },
  img_category: {
    width: dimen(20),
    height: dimen(20),
  },
  part2: {
    backgroundColor: colors.whiteColor,
    paddingBottom: 15
  },
  header_part2: {
    marginLeft: dimen(5),
    borderLeftColor: colors.primaryColor,
    borderLeftWidth: 3,
    marginBottom: 15
  },
  text_header_part2: {
    fontWeight: "bold",
    fontSize: dimen(5),
    paddingLeft: dimen(2),
  }
});
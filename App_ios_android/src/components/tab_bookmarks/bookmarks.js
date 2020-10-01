import React, {PureComponent} from 'react';
import {
  FlatList,
  RefreshControl,
} from 'react-native';
import { connect } from 'react-redux'

import TopBar from '../common/topbar';
import ItemShop from '../shop/_item_shop'

import { UserContext } from '../../store/store'
import {
  fetchShop,
  fetchBookmark
} from '../../actions'
import * as Api from '../../apis/api'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

class App extends PureComponent {
  static contextType = UserContext

  componentDidMount() {
    const {token} = this.context.state
    const {bookmarks, fetchingBookmark} = this.props.userReducer
    if (!bookmarks.length)
      this.props.fetchBookmark(token)
  }

  onRefresh = () => {
    const {token, longitude, latitude} = this.context.state
    this.props.fetchShop(latitude, longitude)
    this.props.fetchBookmark(token)
    // const shops = await Api.favorite_shops(token, latitude, longitude)
  }

  render() {
    const {shops, fetchingShop} = this.props.shopReducer
    const {bookmarks, fetchingBookmark} = this.props.userReducer

    const data = shops.filter(d => bookmarks.indexOf(d.shop_id) > -1)
    return (
      <>     
        <TopBar
          title='ブックマーク'
          hasBack={false}
        />

        <FlatList
          refreshControl={
            <RefreshControl
              refreshing={fetchingShop || fetchingBookmark}
              onRefresh={this.onRefresh}
              tintColor='gray'
            />
          }
          data={data}
          initialNumToRender={10}
          renderItem={({item, index}) =>
            <ItemShop
              key={index}
              mode={2}
              shop={item}
              favorite={true}
              navigation={this.props.navigation}
            />
          }
          keyExtractor={(_, index) => `${index}`}
          contentInset={{ top: dimen(3) }}
        />
      </>
    );
  }
}

function mapStateToProps (state) {
  return {
    userReducer: state.userReducer,
    shopReducer: state.shopReducer
  }
}
function mapDispatchToProps (dispatch) {
  return {
    fetchShop: (lat, lng) => dispatch(fetchShop(lat, lng)),
    fetchBookmark: (token) => dispatch(fetchBookmark(token)),
  }
}
export default connect(
  mapStateToProps,
  mapDispatchToProps
)(App)
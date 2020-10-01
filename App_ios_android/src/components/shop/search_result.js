import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  FlatList,
  RefreshControl,
  TouchableWithoutFeedback,
  Keyboard,
  Alert
} from 'react-native';

import TopBar from '../common/topbar';
import SortBar from '../common/sortBar';
import ItemShop from './_item_shop';
import Indicator from '../common/indicator'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

export default class TopScreen extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);

    const params = props.route.params
    this.state = {
      loading: params.keyword != null,
      keyword: params ? params.keyword : '',
      shops: [],
      orderby: null
    };

    this.onSearchOrder = this.onSearchOrder.bind(this)
    Keyboard.dismiss()
  }

  componentDidMount() {
    this.api_search()
  }

  onSearch = (keyword) => () => {
    this.setState({loading: true, keyword}, () => 
      this.api_search()
    )
  }

  onSearchOrder(orderby) {
    this.setState({loading: true, orderby}, () =>
      this.api_search()
    )
  }

  api_search = async () => {
    const {keyword, orderby} = this.state
    const {longitude, latitude} = this.context.state

    const shops = await Api.search_shop(latitude, longitude, '', keyword, orderby)

    this.setState({shops, loading: false})
  }

  render() {
    const {
      loading, keyword, orderby, shops
    } = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
        <View style={styles.container}>
          <TopBar
            hasSearch={true}
            backColor={colors.primaryColor}
            navigation={this.props.navigation}
            keyword={keyword}
            onSearch={this.onSearch}
          />

          <SortBar orderby={orderby}
            onSearchOrder={this.onSearchOrder}
          />

          <FlatList
            refreshControl={
              <RefreshControl
                refreshing={loading}
                onRefresh={this.api_search}
                tintColor='gray'
              />
            }
            data={shops}
            initialNumToRender={10}
            extraData={shops}
            renderItem={({item, index}) =>
              <ItemShop
                key={index}
                navigation={this.props.navigation}
                shop={item} 
                mode={1}
              />
            }
            style={{flex: 1}}
            keyExtractor={(_, index) => `${index}`}
            contentInset={{ bottom: dimen(3) }}
          />
        </View>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'white'
  },
  content: {
  }
});
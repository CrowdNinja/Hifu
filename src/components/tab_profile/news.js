import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  FlatList,
  RefreshControl,
} from 'react-native';
import moment from 'moment';
import FastImage from 'react-native-fast-image';

import TopBar from '../common/topbar';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

const IMG_NULL = require('../../../assets/images/data_null.png');
const ICON_DEFAULT = require('../../../assets/images/icon_category1.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      loading: true,
      news: []
    };

    this.renderItem = this.renderItem.bind(this)
    this.onRefresh = this.onRefresh.bind(this)
  }

  componentDidMount() {
    this.api_get_news()
  }

  async api_get_news() {
    const {token} = this.state
    const news = await Api.get_news(token)
    this.setState({news: news ?? [], loading: false})
  }

  onRefresh() {
    this.setState({loading: true})
    this.api_get_news()
  }

  renderItem(notification, index) {
    const navigation = this.props.navigation

    return (
      <TouchableOpacity style={styles.part1}
        onPress={() => navigation.push('NewsDetailScreen', {notification: notification})}
      >
        <View style={styles.piece1_block1_part1}>
          <CustomFastImage
            url={notification.img}
            style={styles.piece1_1_block1_part1}
          />
        </View>
        <View style={styles.block2_part1}>
          <View style={styles.piece1_block2_part1}>
            <Text style={styles.piece1_1_block2_part1} numberOfLines={1}>
              {notification.title}
            </Text>
            <Text style={styles.piece1_2_block2_part1} numberOfLines={1}>
              {moment(notification.ctime).format('M月D日HH:mm')}
            </Text>
          </View>
          <Text style={styles.piece2_1_block2_part1} numberOfLines={1}>
            {notification.content}
          </Text>
        </View>
      </TouchableOpacity>
    )
  }

  render() {
    const {
      loading, news
    } = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title="店舗からのご連絡"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {(!loading && news.length == 0) &&
          <View style={styles.view_img}>
            <FastImage
              source={IMG_NULL}
              style={styles.img_null}
            />
          </View>
        }

        <FlatList
          refreshControl={
            <RefreshControl
              tintColor='gray'  
              refreshing={loading}
              onRefresh={this.onRefresh}
            />
          }
          data={news}
          extraData={news}
          initialNumToRender={10}
          renderItem={({item, index}) => this.renderItem(item, index) }
          keyExtractor={(_, index) => `${index}`}
        />
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
      />
    )
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'white',
    position: 'relative'
  },
  part1: {
    backgroundColor: colors.whiteColor,
    padding: dimen(3),
    borderBottomColor: colors.grayColor,
    borderBottomWidth: 1,
    flexDirection: "row",
    alignItems: "center"
  },
  piece1_block1_part1: {
    elevation: 2,
    shadowColor: 'black',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
    marginRight: dimen(3),
    borderRadius: 8,
  },
  piece1_1_block1_part1: {
    width: dimen(15),
    height: dimen(15),
    borderRadius: 8,
    backgroundColor: 'white'
  },
  block2_part1: {    
    flex: 1,
    paddingLeft: dimen(0),
  },
  piece1_block2_part1: {
    flexDirection: "row",
    alignItems: 'center'
  },
  piece1_1_block2_part1: {
    flex: 1,
    fontSize: dimen(4),
    flexShrink: 1,
    marginRight: dimen(5)
  },
  piece1_2_block2_part1: {
    color: colors.textColor,
    flexShrink: 1,
    fontSize: dimen(3),
  },
  piece2_1_block2_part1: {
    fontSize: dimen(3.5),
    color: colors.textColor,
    paddingTop: dimen(2)
  },
  view_img: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
  },
  img_null: {
    width: 150,
    height: undefined,
    aspectRatio: 273/256,
  }
});
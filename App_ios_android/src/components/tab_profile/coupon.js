import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  FlatList,
  RefreshControl,
  Alert
} from 'react-native';
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faCheck } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {ERR_DURATION, ERR_MSG} from '../../config/constant'
import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext, SET_COUPON } from '../../store/store'
import * as Api from '../../apis/api'

const IMG_ACTIVE = require('../../../assets/images/coupon_bg.png');
const IMG_DISABLE = require('../../../assets/images/coup_bg_hui.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      indexSelected: 0,
      loading: true,
      token: context.state.token,
      coupons: [],
      shop_id: props.route.params ? props.route.params.shop_id : null
    };

    this.api_get_coupons = this.api_get_coupons.bind(this)
  }

  componentDidMount() {
    this.api_get_coupons()
  }

  onRefresh = () => {
    this.setState({loading: true})
    this.api_get_coupons()
  }

  onFinish = () => {
    const {coupons, indexSelected} = this.state
    this.context.dispatch({type: SET_COUPON, coupon: coupons[indexSelected]})
    this.props.navigation.goBack()
  }

  async api_get_coupons() {
    const {token, shop_id} = this.state

    const coupons = await Api.get_user_coupon(token, shop_id)
    if (!coupons) {
      this.setState({loading: false}, () => {
        setTimeout(() => {
          Alert.alert(ERR_MSG)
        }, ERR_DURATION)
      })
      return
    }

    this.setState({loading: false, coupons})
  }

  renderItem = (coupon, index) => {
    const {shop_id, indexSelected} = this.state

    return (
      <TouchableOpacity key={index} style={styles.item}
        onPress={() => this.setState({indexSelected: index})}
      >
        <FastImage
          source={coupon.status ? IMG_ACTIVE : IMG_DISABLE}
          style={styles.img_bk}
        >
          <View style={styles.part1}>
            <Text style={styles.piece1_1_block1_part1}>クーポン</Text>
            <View style={styles.piece2_block1_part1}>
              <Text style={styles.piece2_1_block1_part1}>￥</Text>
              <Text style={styles.piece2_2_block1_part1}>{coupon.money}</Text>
            </View>
            <Text style={styles.piece3_1_block1_part1}></Text>
          </View>
          <View style={styles.part2}>
            <Text style={styles.piece1_1_block2_part1}>
              {coupon.title}
            </Text>
            <Text style={styles.piece2_1_block2_part1}>
              {coupon.desc}
            </Text>
            <Text style={styles.piece3_1_block2_part1}>
              {`${coupon.end_time} ${coupon.status_name}`}
            </Text>

            {(shop_id && indexSelected == index) &&
              <View style={styles.view_check}>
                <FontAwesomeIcon icon={faCheck} color='white' />
              </View>
            }
          </View>
        </FastImage>
      </TouchableOpacity>
    )
  }

  render() {
    const {loading, coupons, shop_id} = this.state;
    return (
      <View style={styles.container}>
        <TopBar
          title="クーポン"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        <FlatList
          refreshControl={
            <RefreshControl
              refreshing={loading}
              onRefresh={this.onRefresh}
              tintColor='gray'
            />
          }
          style={{flex: 1}}
          data={coupons.filter(c => c.status ==1)}
          renderItem={({item, index}) => this.renderItem(item, index) }
          keyExtractor={(_, index) => `${index}`}
          contentInset={{ bottom: 100 }}
        />

        {(shop_id && coupons.length > 0) &&
          <TouchableOpacity style={styles.logout_btn}
            onPress={this.onFinish}
          >
            <Text style={styles.logout_txt}>クーポン選択</Text>
          </TouchableOpacity>
        }
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    position: 'relative',
    backgroundColor: '#EEE'
  },
  item: {
    shadowColor: colors.blackColor,
    shadowOffset: {width: 2, height: 2},
    shadowOpacity: 1,
    shadowRadius: 6,
    elevation: 2,
    borderRadius: dimen(2),
    backgroundColor: '#EEE',
    marginTop: dimen(4),
    marginHorizontal: dimen(5),
  },
  img_bk: {
    width: '100%',
    height: undefined,
    aspectRatio: 936/277,
    borderRadius: dimen(2),
    overflow: "hidden",
    flexDirection: "row",
    alignItems: "flex-start",
    padding: dimen(2)
  },
  part1: {
    height: '100%',
    width: dimen(24),
    justifyContent: 'space-between',
  },
  piece1_1_block1_part1: {
    fontSize: dimen(4),
    color: colors.whiteColor
  },
  piece2_block1_part1: {
    flexDirection: "row",
    alignItems: "baseline"
  },
  piece2_1_block1_part1: {
    fontSize: dimen(4),
    color: colors.whiteColor
  },
  piece2_2_block1_part1: {
    fontSize: dimen(6),
    color: colors.whiteColor,
    fontWeight: "bold"
  },
  piece3_1_block1_part1: {
    fontSize: dimen(4),
    color: colors.whiteColor
  },
  part2: {
    flex: 1,
    paddingLeft: dimen(3),
    justifyContent: 'space-between',
    height: '100%',
    position: 'relative'
  },
  piece1_1_block2_part1: {
     fontSize: dimen(4.5),
     width: percent(100)
  },
  piece2_1_block2_part1: {
    fontSize: dimen(3.2),
    color: colors.redColor,
    paddingTop: dimen(2)
  },
  piece3_1_block2_part1: {
    fontSize: dimen(3),
    color: colors.redColor,
    alignItems: "flex-end",
  },
  view_check: {
    position: 'absolute',
    right: 0, top: 0, bottom: 0,
    width: 24,
    height: 24,
    borderRadius: 12,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: colors.primaryColor,
  },
  logout_btn: {
    position: 'absolute',
    bottom: dimen(6),
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
});

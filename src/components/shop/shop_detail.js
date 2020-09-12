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
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronDown, faChevronUp, faMapMarkerAlt } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ItemShop from './_item_shop'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'
import { ScrollView } from 'react-native-gesture-handler';

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      loading: true,
      shop_id: props.route.params.shop_id,
      shop: null
    }
  }

  componentDidMount() {
    this.api_get_shop()
  }

  async api_get_shop() {
    const {token, shop_id} = this.state
    const response = await Api.get_shop_detail(shop_id, token)

    if (response) {
      this.setState({loading: false, shop: response[0]})
    }
  }

  render() {
    const {loading, shop} = this.state;

    return (
      <View style={styles.container}>
        {loading && <Indicator/> }

        <TopBar
          title='店舗紹介'
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {shop != null &&
          <ScrollView>
            <View style={styles.content}>
              <ItemShop
                shop={shop}
                mode={3}
                navigation={this.props.navigation}
              />
              <Text style={styles.txt_title}>{shop.desc_title}</Text>
              <Text style={styles.txt_content}>{shop.desc}</Text>
            </View>
            <Text style={styles.txt_divide}>店舗データ</Text>
            <Item txtA='サロン名' txtB={shop.nickname} />
            <Item txtA='電話番号' txtB={shop.phone} />
            <Item txtA='住所' txtB={shop.address} />
            <Item txtA='アクセス・道案内' txtB={shop.access} />
            <Item txtA='営業時間' txtB={shop.hours} />
            <Item txtA='定休日' txtB={shop.regular_holiday} />
            <Item txtA='設備' txtB={shop.facility} />
            <Item txtA='駐車場' txtB={shop.parking_lot} />
            <Item txtA='こだわり案件' txtB={shop.commitment} />
            <Item txtA='備考' txtB={shop.remarks} />
            <Item txtA='その他' txtB={shop.other} />
          </ScrollView>
        }
      </View>
    );
  }
}

const Item = ({txtA, txtB}) => {
  return (
    <View style={styles.item}>
      <Text style={styles.txt_left}>{txtA}</Text>
      <Text style={styles.txt_right}>{txtB}</Text>
    </View>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.whiteColor,
  },
  content: {
    padding: dimen(3)
  },
  txt_title: {
    fontSize: dimen(4.2),
    fontWeight: 'bold',
    marginVertical: dimen(3),
    color: '#4D4D4D'
  },
  txt_divide: {
    backgroundColor: '#EEEEEE',
    paddingHorizontal: dimen(3),
    paddingVertical: dimen(2),
    color: '#4D4D4D',
    marginBottom: dimen(3)
  },
  item: {
    flexDirection: 'row',
    alignItems: 'center',
    borderTopColor: 'lightgray',
    borderTopWidth: 0.7,
    paddingVertical: dimen(3),
    paddingLeft: dimen(3),
    marginHorizontal: dimen(3)
  },
  txt_left: {
    width: dimen(25),
    fontSize: dimen(4),
    fontWeight: 'bold',
    color: '#4D4D4D'
  },
  txt_right: {
    flex: 1,
    flexShrink: 1,
    fontSize: dimen(3.5),
    color: colors.textColor
  }
});


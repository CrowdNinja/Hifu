import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  Alert
} from 'react-native';
import FastImage from 'react-native-fast-image'

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {ERR_DURATION, ERR_MSG} from '../../config/constant'
import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext } from '../../store/store'
import * as Api from '../../apis/api'

const ICON_ABOUT = require('../../../assets/images/icon_category1.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);
    this.state = {
      loading: true,
      company: '',
      phone: '',
      logo: ''
    };
  }

  componentDidMount() {
    this.api_get_about()
  }

  async api_get_about() {
    const response = await Api.about()

    if (response) {
      this.setState({
        loading: false,
        company: response.company_name,
        phone: response.phone,
        logo: response.logo
      })
    } else {
      this.setState({loading: false}, () => {
        setTimeout(() => {
          Alert.alert(ERR_MSG)
        }, ERR_DURATION)
      })
    }    
  }

  render() {
    const {loading, company, phone, logo} = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title="会社概要"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />          

        {loading && <Indicator/> }

        {!loading &&
          <>
            <FastImage
              style={styles.middleLogo}
              source={logo ? {uri: logo} : ICON_ABOUT }
              onError={() => this.setState({logo: null})}
              resizeMode={'contain'}
            />
            <TouchableOpacity style={styles.item}>
              <Text style={styles.item_txt}>会社名</Text>
              <Text style={styles.item_sub_txt}>{company}</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.item}>
              <Text style={styles.item_txt}>電話番号</Text>
              <Text style={styles.item_sub_txt}>{phone}</Text>
            </TouchableOpacity>
          </>
        }
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'white',
    position: 'relative'
  },
  middleLogo: {
    marginVertical: dimen(8),
    borderRadius: dimen(0.5),
    width: '50%',
    height: dimen(50),
    resizeMode: 'stretch',
    alignSelf: 'center'
  },
  item: {
    height: dimen(15),
    backgroundColor: colors.whiteColor,
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    paddingHorizontal: dimen(3),
    borderTopWidth: 0.5,
    borderTopColor: 'lightgray'
  },
  item_txt: {
    fontSize: dimen(4)
  },
  item_sub_txt: {
    paddingRight: dimen(2),
    fontSize: dimen(4),
    color: 'gray'
  },
});
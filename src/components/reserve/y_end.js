import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import FastImage from 'react-native-fast-image'
import { CommonActions } from '@react-navigation/native';

import TopBar from '../common/topbar';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext, SET_TIMES } from '../../store/store'

const ICON_CHECK = require('../../../assets/images/check.png');
const IMG_QR = require('../../../assets/images/erweima.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    const {trade_id} = context.state

    this.state = {
      trade_id: trade_id
    };

    this.onReset = this.onReset.bind(this)
  }

  onReset() {
    this.props.navigation.dispatch(
      CommonActions.navigate({
        name: 'ShopMenuScreen',
        params: {},
      })
    );
  }

  render() {
    const { trade_id } = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title="注文完了"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
          noBorder={true}
        />

        <View style={styles.content}>
          <FastImage
            style={styles.middleLogo}
            source={ICON_CHECK}
          />
          <Text style = {styles.iconTextStyle}>スキャン完了</Text>
          <FastImage source={IMG_QR} style={[styles.qr_image]}>
            <Text style={styles.fail_text}>
              スキャン完了
            </Text>
          </FastImage>
          <Text style={styles.text_body_part2}>
            ご注文ありがとうございました
          </Text>

          <View style={styles.part3}>
            <TouchableOpacity style = {styles.btnStyle1}
              onPress={() => this.props.navigation.push("ReviewStep", {trade_id: trade_id})}
            >
                <Text style = {styles.registerTextStyle1}>評価する</Text>
            </TouchableOpacity>
            <TouchableOpacity style = {styles.btnStyle2}
              onPress={() => this.onReset()}
            >
              <Text style = {styles.registerTextStyle}>再度購入</Text>
            </TouchableOpacity>
          </View>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    textAlign: 'center',
    backgroundColor: colors.primaryColor,
  },
  content: {
    flex: 1,
    alignItems: 'center',
    backgroundColor: colors.whiteColor,
    margin: dimen(5),
    marginBottom: dimen(15),
    borderRadius: dimen(2)
  },
  middleLogo: {
    width: 80,
    height: 80,
    marginTop: dimen(8),
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(5),
    marginTop: dimen(5),
    textAlign: 'center'
  },
  body_part2: {
    textAlign: "center",
    alignItems: "center",
    position: "relative"
  },
  qr_image: {
    width: dimen(36.8),
    height: dimen(36.8),
    marginTop: dimen(7),
  },
  fail_text: {
    fontSize: dimen(4),
    color: colors.whiteColor,
    lineHeight: dimen(36.8),
    backgroundColor: '#555555CC',
    textAlign: "center",
    fontWeight: "bold"
  },
  text_body_part2: {
    textAlign: "center",
    fontSize: dimen(4),
    paddingTop: dimen(6)
  },
  part3: {
    position: 'absolute',
    bottom: dimen(8),
    flexDirection: "row",
    justifyContent: "space-around",
    width: dimen(90),
  },
  btnStyle2: {
    height: dimen(12),
    borderRadius: dimen(1),
    width: dimen(36),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
    fontSize: dimen(4),
  },
  btnStyle1: {
    height: dimen(12),
    borderRadius: dimen(1),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.whiteColor,
    borderColor: colors.primaryColor,
    borderWidth: 1,
    fontSize: dimen(4),
    width: dimen(36),
  },
  registerTextStyle : {
    color: 'white',
    fontSize: dimen(4)
  },
  registerTextStyle1 : {
    color: colors.primaryColor,
    fontSize: dimen(4)
  },
});

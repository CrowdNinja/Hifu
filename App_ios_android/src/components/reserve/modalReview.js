import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import FastImage from 'react-native-fast-image'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

const LoginLogo = require('../../../assets/images/check.png');

export default class App extends PureComponent {
  goHome = () => this.props.navigation.navigate("TabHome")
  goHistory = () => this.props.navigation.navigate("TabHistory")

  render() {
    const {navigation} = this.props;

    return (
      <View isVisible={true}>
        <View style={styles.fullStyle}>
          <View style={styles.wrapperStyle}>
            <FastImage
              style={styles.middleLogo}
              source={LoginLogo}
            />
            <Text style = {styles.iconTextStyle}>レビューありがとうございました</Text>
            <TouchableOpacity style={styles.btnStyle2}
              onPress={this.goHome}
            >
              <Text style = {styles.registerTextStyle}>トップへ戻る</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.btnStyle1}
              onPress={this.goHistory}
            >
              <Text style = {styles.registerTextStyle1}>予約管理</Text>
            </TouchableOpacity>

          </View>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  wrapper: {},
  middleLogo: {
    width: dimen(16),
    height: dimen(16),
    marginTop: dimen(12),
    left: dimen(37)
  },
  fullStyle: {
    textAlign: 'center',
    width: dimen(100),
    textAlign: 'center',
    height: SCREEN_HEIGHT,
    backgroundColor: colors.lightGrayColor,
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(4.5),
    marginTop: dimen(6),
    textAlign: 'center'
  },
  iconTextStyle1: {
    color: colors.redColor,
    fontSize: dimen(4.5),
    marginTop: dimen(6),
    textAlign: 'center'
  },
  btnStyle2: {
    height: dimen(12),
    borderRadius: dimen(6),
    width: dimen(68),
    left: dimen(11),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
    fontSize: 20,
    marginTop: dimen(20),
  },

  btnStyle1: {
    height: dimen(12),
    borderRadius: dimen(6),
    width: dimen(68),
    left: dimen(11),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.whiteColor,
    borderColor: colors.primaryColor,
    borderWidth: 1,
    fontSize: 20,
    marginTop: dimen(5),
    marginBottom: dimen(13)
  },
  registerTextStyle : {
    color: 'white',
    fontSize: dimen(4)
  },
  registerTextStyle1 : {
    color: colors.primaryColor,
    fontSize: dimen(4)
  },
  wrapperStyle: {
    width: dimen(90),
    left: dimen(5),
    top: dimen(5),
    textAlign: 'center',
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2),
  }
});

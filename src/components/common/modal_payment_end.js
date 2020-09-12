import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import FastImage from 'react-native-fast-image'
import Modal from 'react-native-modal';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

const LoginLogo = require('../../../assets/images/check.png');

export default class App extends PureComponent {
  render() {
    const {onReserve, onOrder} = this.props;
    return (
      <Modal
        isVisible={true}
        animationInTiming={10}
        animationOutTiming={10}
        backdropTransitionInTiming={10}
        backdropTransitionOutTiming={10}
      >
        <View style={styles.wrapperStyle}>
          <FastImage
            style={styles.middleLogo}
            source={LoginLogo}
          />
          <Text style = {styles.iconTextStyle}>購入完了</Text>
          <Text style = {styles.iconTextStyle1}>*購入が成功しました。{"\n"}使用には予約が必要です。</Text>
          <TouchableOpacity style = {styles.btnStyle2}
            onPress={onReserve}
          >
            <Text style = {styles.registerTextStyle}>予約をする</Text>
          </TouchableOpacity>
          <TouchableOpacity style = {styles.btnStyle1} 
            onPress={onOrder}
          >
            <Text style={styles.registerTextStyle1}>注文を見る</Text>
          </TouchableOpacity>
        </View>
      </Modal>
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
    fontSize: dimen(5),
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
    marginTop: dimen(8),
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
  checked: {
    backgroundColor: colors.whiteColor,
    borderWidth: 0,
  },
  checkboxContainerStyle: {
    backgroundColor: 'transparent', 
    marginTop: 0,
    borderWidth: 0,
    paddingTop: 6
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
    alignSelf: 'center',
    textAlign: 'center',
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2),
  }
});

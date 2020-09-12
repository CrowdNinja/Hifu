import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import Modal from 'react-native-modal';
import FastImage from 'react-native-fast-image'

const LoginLogo = require('../../../assets/images/check.png');
const TimesLogo = require('../../../assets/images/times_icon.png');

import {dimen, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
export default class App extends PureComponent {
  render() {
    const {success, onDismiss} = this.props;
    return (
      <Modal
        isVisible={true}
      >
        <View style={styles.fullStyle}>
          <View style={styles.wrapperStyle}>
            {success?
            (<>
              <FastImage
                style={styles.middleLogo}
                source={LoginLogo}
              />
              <Text style = {styles.iconTextStyle}>新規登録が完了しました</Text>
              <TouchableOpacity onPress = {onDismiss}>
                <View style = {styles.btnStyle2} >
                  <Text style = {styles.registerTextStyle}>ログイン</Text>
                </View>
              </TouchableOpacity>
            </>):(
              <>
                <FastImage
                  style={styles.middleLogo}
                  source={TimesLogo}
                />
                <Text style = {styles.iconTextStyle}>新規登録に失敗しました。</Text>
                <TouchableOpacity onPress={onDismiss}>
                  <View style = {styles.btnStyle2} >
                    <Text style = {styles.registerTextStyle}>確認</Text>
                  </View>
                </TouchableOpacity>
              </>
              )}
          </View>
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
    alignSelf: 'center'
  },
  fullStyle: {
    textAlign: 'center',
    textAlign: 'center',
    height: SCREEN_HEIGHT,
    backgroundColor: 'transparent',
  },
  wrapperStyle: {
    height: dimen(73),
    top: dimen(5),
    textAlign: 'center',
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2),
    marginTop: dimen(22)
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(5),
    marginTop: dimen(6),
    textAlign: 'center'
  },
  btnStyle2: {
    height: dimen(12),
    borderRadius: dimen(6),
    width: dimen(68),
    alignSelf: 'center',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
    fontSize: 20,
    marginTop: dimen(13.6),
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
});

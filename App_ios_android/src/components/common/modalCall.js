import React, {PureComponent} from 'react';
import {
  StyleSheet,
  Image,
  View,
  Text,
  TouchableOpacity,
  Linking
} from 'react-native';
import Modal from 'react-native-modal';
import FastImage from 'react-native-fast-image'

import {dimen, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

const ICON_CALL = require('../../../assets/images/servicetel.png');

export default class modalContact extends PureComponent {
  render() {
    const {onClose, phone} = this.props

    return (
      <Modal
        isVisible={true}
        animationType="fade"
      >
        <View>
          <View style={styles.wrapperStyle}>
            <View style={styles.style1}>
              <FastImage
                style={styles.middleLogo}
                source={ICON_CALL}
              />
              <Text style = {styles.iconTextStyle}>
                お問い合わせ</Text>
            </View>

            <Text style = {styles.phonenumberStyle}>{phone}</Text>

            <View style={styles.buttonGroupStyle}>
              <TouchableOpacity style = {styles.btnStyle1}
                onPress = {onClose}
              >
                <Text style = {styles.registerText1Style}>キャンセル</Text>
              </TouchableOpacity>
              <TouchableOpacity style = {styles.btnStyle2}
                onPress = {() => Linking.openURL(`tel:${phone}`) }
              >
                <Text style = {styles.registerTextStyle}>電話</Text>
              </TouchableOpacity>
            </View>
          </View>          
        </View>
      </Modal>
    );
  }
}

const styles = StyleSheet.create({
  wrapper: {},
  middleLogo: {
    width: dimen(8.4),
    height: dimen(8.4),
  },
  wrapperStyle: {
    textAlign: 'center',
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2),
    alignItems: "center",
    paddingTop: dimen(8),
    overflow: 'hidden'
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(5),
    paddingLeft: dimen(2),
    textAlign: 'center',
    alignItems: 'center',
    lineHeight: dimen(8.4),
    textAlignVertical: "center"
  },
  btnStyle2: {
    height: dimen(12),
    width: '50%',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
    fontSize: 20,
  },
  btnStyle1: {
    height: dimen(12),
    width: '50%',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.lightGrayColor,
    fontSize: 20,
  },
  registerTextStyle : {
    color: 'white',
    fontSize: dimen(4.5)
  },
  registerText1Style : {
    color: colors.textColor,
    fontSize: dimen(4.5)
  },
  style1: {
    flexDirection: "row",
    alignItems: "center"
  },
  phonenumberStyle: {
    fontSize: dimen(6),
    color: colors.primaryColor,
    paddingTop: dimen(2.8)
  },
  buttonGroupStyle: {
    flexDirection: "row",
    marginTop: dimen(7.6)
  }
});

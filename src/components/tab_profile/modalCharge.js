import React, {PureComponent} from 'react';
import {
  StyleSheet,
  Image,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import Modal from 'react-native-modal';
import FastImage from 'react-native-fast-image'

import {dimen, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

const check = require('../../../assets/images/check.png');
const times_icon = require('../../../assets/images/times_icon.png');
const ICON_CLOSE = require('../../../assets/images/icon_close.png');

export default class ModalPaymentResult extends PureComponent {
  constructor(props) {
    super(props);
    this.state = {
    };
  }

  render() {
    const {success} = this.props;
    return (
      <Modal isVisible={true} animationType="fade">
        <View style={styles.fullStyle}>
          <View style={styles.wrapperStyle}>
            {success? (
            <>
              <View style={styles.style1}>
                <FastImage
                  style={styles.middleLogo}
                  source={check}
                />
              </View>

              <Text style = {styles.chargeSuccessTextStyle}>チャージ成功</Text>
            </>): (
            <>
              <View style={styles.style1}>
                <FastImage
                  style={styles.middleLogo}
                  source={times_icon}
                />
              </View>
              <Text style = {styles.chargeFailTextStyle}>チャージ失敗</Text>
            </>
            )}
          </View>     
          <View style={styles.buttonGroupStyle}>
            <TouchableOpacity onPress = {() => this.props.onClose()}>
              <FastImage source={ICON_CLOSE} style={styles.closeButtonStyle} />
            </TouchableOpacity>
          </View>     
        </View>
      </Modal>
    );
  }
}

const styles = StyleSheet.create({
  wrapper: {},
  middleLogo: {
    width: dimen(16.8),
    height: dimen(16.8),
  },
  fullStyle: {
    width: dimen(100),
    left: 0,
    marginTop: dimen(-20)
  },
  wrapperStyle: {
    width: dimen(76),
    top: dimen(5),
    left: dimen(8),
    textAlign: 'center',
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2),
    marginTop: dimen(22),
    alignItems: "center",
    paddingTop: dimen(8),
    paddingBottom: dimen(8),
    overflow: "hidden"
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(6),
    textAlign: 'center',
    alignItems: 'center',
    lineHeight: dimen(8.4),
    textAlignVertical: "center"
  },
  btnStyle2: {
    height: dimen(12),
    width: dimen(38),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
    fontSize: 20,
  },
  btnStyle1: {
    height: dimen(12),
    width: dimen(38),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.lightGrayColor,
    fontSize: 20,
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
  chargeFailTextStyle: {
    fontSize: dimen(5),
    color: colors.redColor,
    paddingTop: dimen(6)
  },
  chargeSuccessTextStyle: {
    fontSize: dimen(5),
    color: colors.primaryColor,
    paddingTop: dimen(6)
  },
  buttonGroupStyle: {
    flexDirection: "row",
    textAlign: "center",
    alignItems: "center",
    
  },
  closeButtonStyle: {
    width: dimen(8.8),
    height: dimen(8.8),
    marginTop: dimen(18.6),
    marginLeft: dimen(41.8),
    alignItems: "center",
    margin: "auto",
    left: 0
  }
});

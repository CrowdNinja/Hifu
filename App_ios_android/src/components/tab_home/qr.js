import React, { PureComponent } from 'react';
import {
  View,
  StyleSheet,
  Alert
} from 'react-native';
import QRCodeScanner from 'react-native-qrcode-scanner';
import { RNCamera } from 'react-native-camera';

import TopBar from '../common/topbar';
import ModalCoupon from './modal_coupon'

import { dimen } from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

export default class ScanScreen extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props)

    this.state = {
      showModal: false
    }
  }

  onSuccess = async (e) => {
    const {token} = this.context.state
    const code = await Api.scan_give_coupon(token, e.data)
    if (code == 1) {
      this.setState({showModal: true})
    } else {
      Alert.alert("クーポン取得失敗しました。")
    }
  };

  render() {
    const {showModal} = this.state

    return (
      <View style={{flex: 1}}>
        <TopBar 
          title="クーポン読み取り"
          navigation={this.props.navigation}
        />

        {showModal && <ModalCoupon navigation={this.props.navigation} />}

        <QRCodeScanner
          onRead={this.onSuccess}
          flashMode={RNCamera.Constants.FlashMode.torch}
          cameraStyle={styles.cameraStyle}
          containerStyle={styles.containerStyle}
          topViewStyle={styles.topViewStyle}
          topContent={
            <></>
          }
          bottomContent={
            <></>
          }
        />
      </View>
    );
  }
}

const styles = StyleSheet.create({
  containerStyle: {
    flex: 1,
    backgroundColor: 'black'
  },
  cameraStyle: {
    flex: 1
  },
  topViewStyle: {
    height: 0,
    backgroundColor: 'black'
  }
});
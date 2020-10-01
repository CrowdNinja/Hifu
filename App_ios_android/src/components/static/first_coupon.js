import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView
} from 'react-native';
import FastImage from 'react-native-fast-image'

import TopBar from '../common/topbar';

import { dimen } from '../../config/dimen';
import colors from '../../config/colors';

const IMG_COUPON = require('../../../assets/images/img_first_coupon.png');

export default class App extends PureComponent {

  render() {
    const {
      navigation
    } = this.props;

    return (
      <View style={styles.container}>
        <TopBar
          title="初回クーポン"
          backColor={colors.primaryColor}
          navigation={navigation}
          noBorder={true}
        />
        <View style={styles.content}>
          <Text style={styles.txt_top}>ダウンロードありがとうございます！</Text>
          <FastImage source={IMG_COUPON} style={styles.image} />
          <TouchableOpacity style={styles.btn}
            onPress={() => navigation.navigate("TabMainStack", {
              screen: "TabMypage"
            })}
          >
            <Text style={styles.txt_btn}>会員登録</Text>
          </TouchableOpacity>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    position: 'relative',
    backgroundColor: colors.primaryColor,
  },
  content: {
    backgroundColor: 'white',
    borderRadius: dimen(2),
    marginHorizontal: dimen(5),
    marginTop: dimen(4)
  },
  txt_top: {
    textAlign: 'center',
    fontSize: dimen(4),
    paddingTop: dimen(7),
    paddingBottom: dimen(3.5)
  },
  image: {
    height: undefined,
    aspectRatio: 1/1,
    marginHorizontal: dimen(3.5),
    borderRadius: dimen(1)
  },
  btn: {
    marginTop: dimen(14),
    marginBottom: dimen(8),
    width: dimen(40),
    height: dimen(12),
    alignSelf: 'center',
    backgroundColor: colors.primaryColor,
    borderRadius: dimen(1.5),
    alignItems: 'center',
    justifyContent: 'center'
  },
  txt_btn: {
    color: 'white',
    fontSize: dimen(4)
  }
});

import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import FastImage from 'react-native-fast-image'
import {SCREEN_WIDTH, SCREEN_HEIGHT, dimen} from '../../config/dimen';

const LoginLogo = require('../../../assets/images/login.png');

export default class App extends PureComponent {
  onSignup = () => this.props.navigation.push('SignUpScreen')
  onSignin = () => this.props.navigation.push('SignInScreen')

  render() {
    return (
      <View style={styles.container}>
        <View style={styles.content}>
          <FastImage
            style={styles.middleLogo}
            source={LoginLogo}
          />
          <Text style={styles.text1}>ログイン後、マイページを表示できます</Text>
        </View>
        <View style={styles.btns}>
          <TouchableOpacity style = {styles.btnStyle1}
            onPress={this.onSignin}
          >
            <Text style = {{color: 'white', fontSize: dimen(4)}}>ログイン</Text>
          </TouchableOpacity>
          <TouchableOpacity style={styles.btnStyle2}
            onPress={this.onSignup}
          >
            <Text style = {{color: 'white', fontSize: dimen(4)}}>新規登録</Text>
          </TouchableOpacity>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#4fa5b8',
  },
  content: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center'
  },
  middleLogo: {
    width: SCREEN_WIDTH * 0.4,
    height: undefined,
    aspectRatio: 387/327,
  },
  text1: {
    color: 'white',
    fontSize: dimen(4.5),
    lineHeight: dimen(17),
  },
  btnStyle1: {
    height: dimen(10),
    borderRadius: dimen(20),
    width: SCREEN_WIDTH * 0.85,
    backgroundColor: 'rgba(255, 255, 255, 0.4)',
    justifyContent: 'center',
    alignItems: 'center',
  },
  btnStyle2: {
    marginTop: dimen(5),
    height: dimen(10),
    borderRadius: dimen(20),
    borderWidth: 2,
    borderColor: 'rgba(255, 255, 255, 0.4)',
    width: SCREEN_WIDTH * 0.85,
    justifyContent: 'center',
    alignItems: 'center',
    color: 'white',
    fontSize: 20,
  },
  btns: {
    alignItems: 'center',
    bottom: dimen(5)
  }
});

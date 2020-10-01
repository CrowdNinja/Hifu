import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TextInput,
  TouchableOpacity,
  TouchableWithoutFeedback,
  Alert,
  Keyboard,
} from 'react-native';
import CheckBox from 'react-native-check-box'
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faEye, faUnlock } from '@fortawesome/free-solid-svg-icons';
import { faUser } from '@fortawesome/free-regular-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator';

import {ERR_DURATION, ERR_MSG} from '../../config/constant'
import {dimen} from '../../config/dimen';
import colors from '../../config/colors';
import {setStorage} from '../../config/storage'
import * as Api from '../../apis/api'
import { UserContext, SET_PROFILE } from '../../store/store'

const LoginLogo = require('../../../assets/images/logo1.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);
    this.state = {
      loading: false,
      error: null,
      checked: true,
      phone: '',
      password: '',
      hidePassword: true
    };

    this.onChangeText = this.onChangeText.bind(this)
  }

  onChangeText(text, kind) {
    if (kind) {
      this.setState({password: text})
    } else {
      this.setState({phone: text})
    }
  }

  onLogin = () => {
    const { phone, password } = this.state
    if (!phone.length || !password.length) {
      Alert.alert('ユーザー情報を入力してください')
      return
    }

    this.setState({loading: true})
    this.async_login()
  }

  async async_login() {
    const { phone, password } = this.state
    const result = await Api.sign_in(phone, password)
    if (!result) {
      this.setState({loading: false}, () => {
        setTimeout(() => {
          Alert.alert(ERR_MSG)
        }, ERR_DURATION)
      })
      return
    }

    const token = result.token
    if (token) {  
      setStorage(token)
      const user = await Api.get_profile(token)
      
      this.context.dispatch({type: SET_PROFILE,
        nickname: user.nickname, token: token, account: user.account, avatar: user.avatar, money: user.money,
        address: user.address, pay_password1: user.pay_password1,
        square_customer_id: user.square_customer_id
      })
    } else {
      this.setState({loading: false}, () => 
        setTimeout(() => {
          Alert.alert('ログイン失敗')
        }, 500)
      )
    }
  }

  render() {
    const {loading, phone, password, checked, hidePassword} = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <View style={styles.container}>
        <TopBar
          title="ログイン"
          navigation={this.props.navigation}
        />

        {loading && <Indicator/> }

        <View style={styles.content}>
          <FastImage
            style={styles.middleLogo}
            source={LoginLogo}
          />
          <View style={styles.formInputStyle}>
            <FontAwesomeIcon icon={faUser} size={dimen(4)} color={colors.lightBlackColor} />
            <TextInput
              style={styles.emailStyle}
              onChangeText={text => this.onChangeText(text, 0)}
              value={phone}
              placeholder="携帯電話番号"
              placeholderTextColor='gray'
              keyboardType='numeric'
            />
          </View>

          <View style={styles.passwordFormInputStyle}>
            <FontAwesomeIcon icon={faUnlock} size={dimen(4)} color={colors.lightBlackColor} />
            <TextInput
              style={styles.passwordStyle}
              onChangeText={text => this.onChangeText(text, 1)}
              value={password}
              placeholder="ログインパスワード"
              secureTextEntry={hidePassword}
              placeholderTextColor='gray'
            />
            <TouchableOpacity
              onPress={() => this.setState({hidePassword: !hidePassword}) }
            >
              <FontAwesomeIcon icon={faEye} size={dimen(5)} color={colors.lightBlackColor} />
            </TouchableOpacity>
          </View>

          <View style={styles.checkboxFormInputStyle}>
            <CheckBox
              style={styles.checkboxContainerStyle}
              onClick={ () => { this.setState({checked: !checked}) } }
              isChecked={checked}
              rightText="ログイン状態を保存する"
              rightTextStyle={styles.checked}
              checkBoxColor={colors.primaryColor}
              checkedCheckBoxColor={colors.primaryColor}
              uncheckedCheckBoxColor={colors.primaryColor}
            />
          </View>

          <View style={styles.btns}>
            <TouchableOpacity style = {styles.btnStyle1}
              onPress={this.onLogin}
            >
              <Text style = {styles.loginTextStyle}>ログイン</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.btnStyle2}
              onPress = {() => this.props.navigation.navigate('SignUpScreen')}
            >
              <Text style = {styles.registerTextStyle}>登録</Text>
            </TouchableOpacity>
          </View>
        </View>
      </View>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.primaryColor
  },
  content: {
    flex: 1,
    backgroundColor: 'white',
    alignItems: 'center',
  },
  middleLogo: {
    width: dimen(50),
    height: undefined,
    aspectRatio: 1799/1804,
    alignSelf: 'center'
  },
  formInputStyle: {
    textAlign: 'left',
    width: dimen(88),
    flexDirection: 'row',
    alignItems: 'center',
    paddingBottom: dimen(1),
    borderBottomWidth: 1,
    borderBottomColor: colors.grayColor
  },
  passwordFormInputStyle: {
    textAlign: 'left',
    width: dimen(88),
    paddingBottom: dimen(1),
    flexDirection: 'row',
    alignItems: 'center',
    borderBottomWidth: 1,
    borderBottomColor: colors.grayColor,
    marginTop: dimen(4)
  },
  checkboxFormInputStyle: {
    alignSelf: 'flex-start',
    textAlign: 'left',
    marginLeft: dimen(5),
    paddingVertical: dimen(3),
    width: dimen(80)
  },
  emailStyle: {
    width: dimen(80),
    left: dimen(4),
    color: colors.blackColor,
    height: dimen(5.5),
    padding: 0,
    margin: 0
  },
  passwordStyle: {
    width: dimen(79),
    left: dimen(4),
    color: colors.blackColor,
    height: dimen(5.5),
    padding: 0,
    margin: 0
  },
  label: {
    margin: 8,
  },
  btnStyle1: {
    height: dimen(10),
    borderRadius: dimen(6),
    width: dimen(90),
    backgroundColor: colors.primaryColor,
    justifyContent: 'center',
    alignItems: 'center',
    color: 'white',
    fontSize: 20
  },
  btnStyle2: {
    marginTop: dimen(5),
    height: dimen(10),
    borderRadius: dimen(6),
    borderWidth: 2,
    borderColor:  colors.primaryColor,
    width: dimen(90),
    justifyContent: 'center',
    alignItems: 'center',
    color:  colors.primaryColor,
    fontSize: 20,
  },
  loginTextStyle: {color: 'white', fontSize: dimen(4)},
  registerTextStyle: {
    color: colors.primaryColor,
    fontSize: dimen(4)
  },
  checked: {
    color: colors.textColor,
    fontSize: dimen(3.5)
  },
  btns: {
    position: 'absolute',
    bottom: dimen(5)
  }
});

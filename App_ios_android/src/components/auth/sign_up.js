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
  KeyboardAvoidingView,
} from 'react-native';
import FastImage from 'react-native-fast-image'
import CountryPicker from 'react-native-country-picker-modal'

import TopBar from '../common/topbar';
import Indicator from '../common/indicator';
import ModalApi from './modalApi'

import {ERR_DURATION, ERR_MSG} from '../../config/constant'
import {setStorage} from '../../config/storage'
import {dimen} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext, SET_PROFILE } from '../../store/store'

import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faUser, faUnlock, faMobileAlt, faKey } from '@fortawesome/free-solid-svg-icons';

const LoginLogo = require('../../../assets/images/logo1.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);
    this.state = {
      loading: false,
      nickname: '',
      password: '',
      phoneNumber: '',
      code: '',
      countryCode: 'JP',
      callingCode: '81',
      visibleDlg: false,
      apiSuccess: false,
      token: null
    };

    this.onChangeText = this.onChangeText.bind(this)
  }

  onSignUp = () => {
    const {nickname, password, phoneNumber, code} = this.state

    if (!nickname.length) {
      Alert.alert('お名前（フルネーム）を入力してください')
      return
    }
    if (!phoneNumber.length) {
      Alert.alert('携帯電話番号を入力してください')
      return
    }
    if (password.length < 8) {
      Alert.alert('パスワードは半角英数字８文字以上')
      return
    }
    if (code.length != 4) {
      Alert.alert('コードが違います。')
      return
    }
    
    this.setState({loading: true})
    this.api_sign_up()
  }

  async api_sign_up() {
    const {nickname, password, phoneNumber, code} = this.state
    const result = await Api.sign_up(nickname, password, phoneNumber, code)

    if (!result) {
      this.setState({loading: false}, () => {
        setTimeout(() => {
          Alert.alert(ERR_MSG)
        }, ERR_DURATION)
      })
      return
    }

    const token = result.token
    this.setState({loading: false}, () => {
      setTimeout(() => {
        this.setState({
          visibleDlg: true,
          apiSuccess: token != null,
          token
        })
      }, ERR_DURATION)
    })
  }

  onChangeText(text, kind) {
    if (kind == 0) {
      this.setState({nickname: text})
    } else if (kind == 1) {
      this.setState({password: text})
    } else if (kind == 2) {
      this.setState({phoneNumber: text})
    } else {
      this.setState({code: text})
    }
  }

  onSelect = (country) => {
    this.setState({countryCode: country.cca2, callingCode: country.callingCode[0]})
  }

  getSms = () => {
    const {phoneNumber, callingCode} = this.state
    if (!phoneNumber.length) {
      Alert.alert("電話番号を入力してください")
      return
    }

    this.setState({loading: true}, () =>
      this.api_get_sms()
    )
  }

  api_get_sms = async () => {
    const {phoneNumber, callingCode} = this.state
    const response = await Api.get_sms(phoneNumber, callingCode)

    if (response) {
      this.setState({loading: false}, () => 
        setTimeout(() => {
          Alert.alert( response.msg == '短信发送成功' ? '認証コードを確認してください' : '認証コードの送信に失敗しました' )
        }, ERR_DURATION)
      )
    } else {
      this.setState({loading: false}, () => {
        setTimeout(() => {
          Alert.alert(ERR_MSG)
        }, ERR_DURATION)
      })
    }
  }

  onDismiss = async () => {
    const {visibleDlg, apiSuccess, token} = this.state
    this.setState({visibleDlg: !visibleDlg})
    if (apiSuccess && token) {
      setStorage(token)
      const user = await Api.get_profile(token)

      this.context.dispatch({type: SET_PROFILE,
        nickname: user.nickname, token: token, avatar: user.avatar, money: user.money,
        address: user.address, pay_password1: user.pay_password1,
        square_customer_id: user.square_customer_id
      })
      this.props.navigation.push("TermScreen", {account: user.account})
    }
  }

  render() {
    const {
      loading, nickname, password, phoneNumber, code, countryCode,
      visibleDlg, apiSuccess
    } = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
        <KeyboardAvoidingView style={{flex: 1}}
            behavior={Platform.OS === 'ios' ? "padding" : ''}
            enabled
          >
          <View style={styles.wrapper}>
            <TopBar
              title="新規登録"
              backColor={colors.primaryColor}
              navigation={this.props.navigation}
            />

            {loading && <Indicator/> }
            {visibleDlg &&
              <ModalApi
                success={apiSuccess}
                onDismiss={this.onDismiss}
              />
            }

            <View style={styles.fullStyle}>
              <FastImage
                style={styles.middleLogo}
                source={LoginLogo}
              />

              <View style={styles.formInputStyle}>
                <FontAwesomeIcon icon={faUser} size={dimen(4)} color={colors.lightBlackColor} />
                <TextInput
                  style={styles.emailStyle}
                  onChangeText={text => this.onChangeText(text, 0)}
                  value={nickname}
                  placeholder="お名前（フルネーム）"
                  placeholderTextColor='gray'
                />
              </View>
              <View style={styles.passwordFormInputStyle}>
                <FontAwesomeIcon icon={faUnlock} size={dimen(4)} color={colors.lightBlackColor} />
                <TextInput
                  style={styles.emailStyle}
                  onChangeText={text => this.onChangeText(text, 1)}
                  value={password}
                  placeholder="ログインパスワード"
                  placeholderTextColor='gray'
                  secureTextEntry={true}
                />
              </View>
              <View style={styles.passwordFormInputStyle}>
                <FontAwesomeIcon icon={faMobileAlt} size={dimen(4)} color={colors.lightBlackColor} />
                <TextInput
                  style={styles.emailStyle}
                  onChangeText={text => this.onChangeText(text, 2)}
                  value={phoneNumber}
                  placeholder="携帯電話番号"
                  keyboardType='numeric'
                  placeholderTextColor='gray'
                />

                <TouchableOpacity
                  style={styles.country_code}
                  onPress={() => this.setState({show: true})}>
                  <CountryPicker
                    countryCode={countryCode}
                    withFlag={true}
                    withCallingCodeButton={true}
                    withAlphaFilter={true}
                    withCallingCode={true}
                    onSelect={this.onSelect}
                  />
                </TouchableOpacity>

              </View>
              <View style={styles.passwordFormInputStyle}>
                <FontAwesomeIcon icon={faKey} size={dimen(4)} color={colors.lightBlackColor} />
                <TextInput
                  style={styles.codeConfirmStyle}
                  onChangeText={text => this.onChangeText(text, 3)}
                  value={code}
                  placeholder="確認コード"
                  placeholderTextColor='gray'
                  keyboardType='numeric'
                />
                <TouchableOpacity onPress={this.getSms}>
                  <Text style = {styles.codeConfirmTextStyle}>｜　確認コードを入手する</Text>
                </TouchableOpacity>
              </View>
            </View>

            <TouchableOpacity style = {styles.btnStyle1} 
              onPress = {this.onSignUp}
            >
              <Text style={styles.loginTextStyle}>今すぐ登録</Text>
            </TouchableOpacity>
          </View>
        </KeyboardAvoidingView>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  wrapper: {
    flex: 1,
    backgroundColor: colors.whiteColor
  },
  middleLogo: {
    width: dimen(50),
    height: undefined,
    aspectRatio: 1799/1804,
    alignSelf: 'center'
  },
  fullStyle: {
    alignItems: 'center'
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
  emailStyle: {
    width: dimen(80),
    color: colors.blackColor,
    height: dimen(5.5),
    padding: 0,
    margin: 0,
    left: dimen(2)
  },
  label: {
    margin: 8,
  },
  btnStyle1: {
    position: 'absolute',
    bottom: dimen(5),
    height: dimen(10),
    borderRadius: dimen(6),
    width: dimen(90),
    alignSelf: 'center',
    backgroundColor: colors.primaryColor,
    justifyContent: 'center',
    alignItems: 'center',
    color: 'white',
    marginTop: dimen(15),
    fontSize: 20
  },
  loginTextStyle: {color: 'white', fontSize: 20},
  registerTextStyle: {color: colors.primaryColor, fontSize: 20},
  titleStyle1: {
    color: 'white',
    fontSize: dimen(14),
    lineHeight: dimen(24),
    fontWeight: 'bold',
  },
  titleStyle2: {
    fontSize: dimen(14),
    lineHeight: dimen(24),
    fontWeight: 'bold',
  },
  codeConfirmStyle: {
    width: dimen(45),
    left: dimen(2),
    color: colors.blackColor,
    height: dimen(5.5),
    padding: 0,
    margin: 0
  },
  codeConfirmTextStyle: {
    color: colors.primaryColor,
    fontSize: dimen(3.5),
    fontWeight: 'bold',
  },
  country_code: {
    position: 'absolute',
    right: 0,
    bottom: dimen(1)
  }
});

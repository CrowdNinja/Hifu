import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TextInput,
  TouchableOpacity,
  TouchableWithoutFeedback,
  Keyboard,
  Alert
} from 'react-native';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext } from '../../store/store'
import * as Api from '../../apis/api'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      password: '',
      newPassword: '',
      confirmPassword: ''
    };

    this.onSave = this.onSave.bind(this)
  }

  onSave() {
    const {password, newPassword, confirmPassword} = this.state

    if (password.length < 8 || newPassword.length < 8 || confirmPassword.length < 8) {
      Alert.alert("正確に入力してください。")
      return
    }

    if (newPassword != confirmPassword) {
      Alert.alert("パスワードが違います。")
      return
    }

    this.setState({loading: true})
    this.api_edit_password()
  }

  async api_edit_password() {
    const {token, password, newPassword, confirmPassword} = this.state

    const response = await Api.edit_password(token, password, newPassword, confirmPassword)
    this.setState({loading: false}, () => {
      setTimeout(() => {
        Alert.alert(response.account ? 'パスワード変更しました。' : 'パスワード変更に失敗しました。')
      }, 500)
    })
  }

  render() {
    const {loading, password, newPassword, confirmPassword} = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <View style={styles.container}>
        <TopBar
          title="ログインパスワードの変更"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {loading && <Indicator/> }

        <View style={styles.item}>
          <TextInput style={styles.textedit} value={password}
            onChangeText={text => this.setState({password: text}) }
            secureTextEntry={true}
            placeholder='旧パスワードを入力'
            placeholderTextColor='gray'
          />
        </View>
        <View style={styles.item}>
          <TextInput style={styles.textedit} value={newPassword}
            onChangeText={text => this.setState({newPassword: text}) }
            secureTextEntry={true}
            placeholder='新しいパスワードを入力'
            placeholderTextColor='gray'
          />
        </View>
        <View style={styles.item}>
          <TextInput style={styles.textedit} value={confirmPassword}
            onChangeText={text => this.setState({confirmPassword: text}) }
            secureTextEntry={true}
            placeholder='パスワードの確認を入力'
            placeholderTextColor='gray'
          />
        </View>
        <Text style={styles.notes_text}>パスワードは8文字以上の英数字の組み合せ/大文字は区別する</Text>

        <TouchableOpacity style={styles.part3}
          onPress={() => this.onSave() }
        >
          <View style={styles.block1_part3}>
            <Text style={styles.text_block1_part3}>変更する</Text>
          </View>
        </TouchableOpacity>
      </View>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  item: {
    backgroundColor: 'white',
    height: dimen(14),
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    borderBottomColor: 'lightgray',
    borderBottomWidth: 0.3,
    paddingHorizontal: dimen(3)
  },
  label: {
    fontSize: dimen(4),
    fontWeight: 'bold',
    color: colors.backColor
  },
  textedit: {
    marginLeft: 8,
    flex: 1,
    color: colors.blackColor,
    fontSize: dimen(4),
  },
  view_address: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
  },
  part3: {
    position: "absolute",
    bottom:0,
    width: dimen(100),
    left: dimen(0),
    height: dimen(20),
    padding: dimen(4),
    backgroundColor: colors.whiteColor
  },
  block1_part3: {
    backgroundColor: colors.primaryColor,
    textAlign: "center",
    borderRadius: dimen(6),
    overflow: "hidden"
  },
  text_block1_part3: {
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(12),
    fontSize: dimen(6)
  },
  notes_text: {
    color: 'gray',
    padding: dimen(3)
  }
});

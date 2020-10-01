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
import { UserContext, SET_PHONE } from '../../store/store'
import * as Api from '../../apis/api'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      loading: false,
      oldPhone: context.state.account,
      phone: '',
      code: ''
    };

    this.onSave = this.onSave.bind(this)
    this.getSms = this.getSms.bind(this)
  }

  onSave() {
    const {phone, code} = this.state

    if (phone.length != 11) {
      Alert.alert("電話番号を正確に入力してください")
      return
    }
    if (code.length != 4) {
      Alert.alert('コードが違います。')
      return
    }

    this.setState({loading: true})
    this.api_edit_phone()
  }

  getSms() {
    const {phone} = this.state
    if (phone.length != 11) {
      Alert.alert("電話番号を正確に入力してください")
      return
    }

    this.setState({loading: true}, () =>
      this.api_get_sms()
    )
  }

  async api_edit_phone() {
    const {token, oldPhone, phone, code} = this.state
    const result = await Api.edit_phone(token, phone, code)

    this.setState({loading: false}, () => {
      setTimeout(() => {
        if (result.code == 1) {
          this.context.dispatch({type: SET_PHONE, account: result.data.account})
          Alert.alert(
            '電話番号を変更しました。',
            '', [{
                text: '確認',
                onPress: () => this.props.navigation.goBack(),
                style: 'cancel'
            }], {
                cancelable: false
            }
          )
        } else {
          Alert.alert("電話番号変更失敗！")
        }
      }, 500)
    })
  }

  async api_get_sms() {
    const {phone} = this.state
    const response = await Api.get_sms(phone, '81')

    this.setState({loading: false}, () => 
      setTimeout(() => {
        Alert.alert( response.msg == '短信发送成功' ? '認証コードを確認してください' : '認証コードの送信に失敗しました' )
      }, 500)
    )
  }

  render() {
    const {
      loading, oldPhone, phone, code
    } = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <View style={styles.container}>
        <TopBar
          title="携帯電話番号の変更"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {loading && <Indicator/> }

        <View style={styles.item}>
          <Text style={styles.textedit}>携帯電話番号：{oldPhone}</Text>
        </View>
        <View style={styles.item}>
          <TextInput style={styles.textedit} value={phone}
            onChangeText={text => this.setState({phone: text}) }
            placeholder='新しい携帯電話番号'
            placeholderTextColor='gray'
            keyboardType='numeric'
          />
          <TouchableOpacity onPress={()=> this.getSms() }>
            <Text style={styles.piece1_3_1_block1_part2}>確認コードを{"\n"}入手する</Text>
          </TouchableOpacity>
        </View>
        <View style={styles.item}>
          <TextInput style={styles.textedit} value={code}
            onChangeText={text => this.setState({code: text}) }
            placeholder='確認コード'
            placeholderTextColor='gray'
            keyboardType='numeric'
          />
        </View>

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
  },
  piece1_3_1_block1_part2: {
    lineHeight: dimen(3.5),
    paddingRight: dimen(2),
    fontSize: dimen(3.4),
    color: colors.primaryColor
  }
});
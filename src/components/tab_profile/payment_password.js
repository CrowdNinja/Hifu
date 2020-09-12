import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  TouchableWithoutFeedback,
  Keyboard,
  Alert
} from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronRight } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import ConfirmPassword from '../common/confirm_password';
import Indicator from '../common/indicator';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext, SET_PAY_PASSWORD } from '../../store/store'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      loading: false,
      step: context.state.pay_password1 ? 0 : 1,
      value: '',
      mode: props.route.params ? props.route.params.mode : 0,
    };

    this.onNext = this.onNext.bind(this)
  }

  componentDidMount() {
  }

  async api_check_pass(value) {
    const {token} = this.context.state
    const result = await Api.check_pay_password(token, value)

    if (result) {
      if (this.state.mode) {
        this.setState({loading: false})
        this.props.route.params.onBack()
        this.props.navigation.goBack()
      } else {
        this.setState({loading: false, step: 1}, () => {
          setTimeout(() => {
            Alert.alert("新しいパスワードを設定してください。")
          }, 250)
        })
      }
    } else {
      this.setState({loading: false}, () => {
        setTimeout(() => {
          Alert.alert("パスワードが違います。")
        }, 250)
      })
    }
  }

  async api_set_pass(value) {
    const {token} = this.context.state
    const result = await Api.edit_pay_pass(token, value)
    
    if (result) {
      this.setState({loading: false, step: 0}, () => {
        setTimeout(() => {
          Alert.alert(
            'パスワードを変更しました。',
            '',
            [
              {
                text: '確認',
                onPress: () => {
                  this.context.dispatch({type: SET_PAY_PASSWORD, pay_password1: value})
                  this.props.navigation.goBack()
                }
              },
            ],
            { cancelable: false }
          );
        }, 100)
      })
    } else {
      this.setState({loading: false, step: 0}, () => {
        setTimeout(() => {
          Alert.alert(
            'パスワード変更失敗！',
            '',
            [
              {
                text: '確認',
                onPress: () => {
                  this.props.navigation.goBack()
                }
              },
            ],
            { cancelable: false }
          );
        }, 100)
      })
    }
  }

  onNext(value) {
    const {step} = this.state

    if (step == 0) {
      this.setState({loading: true})
      this.api_check_pass(value)
    } else if (step == 1) {
      this.setState({value: value, step: 2})
    } else {
      if (value != this.state.value) {
        Alert.alert("パスワードが違います")
      } else {
        this.setState({loading: true})
        this.api_set_pass(value)
      }
    }
  }

  render() {
    const {loading, step} = this.state;
    
    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <View style={styles.container}>
        <TopBar
          title="お支払い確定"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />
        {loading && <Indicator/> }
        <ConfirmPassword onNext={this.onNext} step={step}/>
      </View>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'white'
  }
});

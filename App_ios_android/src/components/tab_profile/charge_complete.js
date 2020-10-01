import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
} from 'react-native';

import Indicator from '../common/indicator'
import ModalCharge from './modalCharge'

import { UserContext, SET_MY_MONEY } from '../../store/store'
import * as Api from '../../apis/api'

import {ERR_DURATION} from '../../config/constant'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      loading: true,
      visible: false,
      line_pay_status: props.route.params.line_pay_status
    };
  }

  async componentDidMount() {
    const {token} = this.context.state
    const {line_pay_status} = this.state

    if (line_pay_status) {
      const user = await Api.get_profile(token)
      this.context.dispatch({type: SET_MY_MONEY, money: user.money})
    }

    this.setState({loading: false}, () =>
      setTimeout(() => this.setState({visible: true}), 300)
    )
  }

  onClose = () => {
    this.props.navigation.navigate("TabMainStack", {
      screen: 'TabMypage',
      params: {
        screen: 'ChargeScreen'
      }
    })
  }

  render() {
    const {loading, visible, line_pay_status} = this.state

    return (
      <View style={styles.container}>
        {loading && <Indicator />}
        {visible &&
          <ModalCharge success={line_pay_status} onClose={this.onClose} />
        }
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  }
});

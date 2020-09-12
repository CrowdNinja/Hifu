import React, { PureComponent } from 'react'
import {
  Platform,
  Linking,
  Alert
} from 'react-native'

import { createStackNavigator } from '@react-navigation/stack';

import TabMain from './tabs'
import Reservation from './reserve'
import ShopStack from './shop'
import FirstCoupon from './static/first_coupon'

import { UserContext, SET_TRADE } from '../store/store'
import * as Api from '../apis/api'

const Stack = createStackNavigator();

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props)
  }
  componentDidMount() { // B
    if (Platform.OS === 'android') {
      Linking.getInitialURL().then(url => {
        if (url) this.navigate(url);
      });
    } else {
      Linking.addEventListener('url', this.handleOpenURL);
    }
  }
  componentWillUnmount() {
    Linking.removeEventListener('url', this.handleOpenURL);
  }
  handleOpenURL = (event) => this.navigate(event.url);
  navigate = async (url) => {
    const route = url.replace(/.*?:\/\//g, '');
    const screen = route.split('?')[0]
    const params = route.split('?')[1]

    var status = false
    params.split('&').map(p => {
      const param = p.split('=')
      switch(param[0]) {
        case 'trade_id':
          this.context.dispatch({type: SET_TRADE, trade_id: parseInt(param[1])})
          break;
        case 'status':
          status = param[1] == 'true'
          break;
      }
    })

    if (!status) {
      Alert.alert('LINE決済失敗！')
      return
    }

    if (screen == 'reserve') {
      this.props.navigation.navigate("ReservationStack", {
        screen: 'PayResultStep',
        params: {
          status: status
        }
      })
    } else if (screen == 'recharge') {
      this.props.navigation.navigate("TabMainStack", {
        screen: 'TabMypage',
        params: {
          screen: 'ChargeResultScreen',
          params: {
            line_pay_status: status
          }
        }
      })
    }
  }

  render() {
    return (
      <Stack.Navigator headerMode="none">
        <Stack.Screen
          name="TabMainStack"
          component={TabMain}
        />
        <Stack.Screen
          name="FirstCoupon"
          component={FirstCoupon}
        />
        <Stack.Screen
          name="ShopStack"
          component={ShopStack}
        />
        <Stack.Screen
          name="ReservationStack"
          component={Reservation}
        />
      </Stack.Navigator>
    );
  }
}

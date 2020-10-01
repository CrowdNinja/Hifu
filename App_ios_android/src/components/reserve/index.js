import React, { PureComponent } from 'react'

import { createStackNavigator } from '@react-navigation/stack';

import PaymentStep from './payment';
import PayResultStep from './pay_result';
import CouponStep from '../tab_profile/coupon';
import PasswordStep from '../tab_profile/payment_password';
import TimeSelectStep from './timeSelect';
import ReserveStep from './reserve';
import ReserveConfirmStep from './x_confirm';
import OrderEndStep from './y_end';
import ReviewStep from './z_review';


const Stack = createStackNavigator();

import { UserContext } from '../../store/store'

export default class App extends PureComponent {
  static contextType = UserContext

  render() {
    const {initial} = this.props.route.params

    return (
      <Stack.Navigator
        headerMode="none"
        screenOptions={{
        }}
        initialRouteName={initial ?? 'PaymentStep'}
      >
        <Stack.Screen
          name="PaymentStep"
          component={PaymentStep}
          initialParams={this.props.route.params}
        />
        <Stack.Screen
          name="PayResultStep"
          component={PayResultStep}
        />
        <Stack.Screen
          name="CouponStep"
          component={CouponStep}
        />
        <Stack.Screen
          name="PasswordStep"
          component={PasswordStep}
        />
        <Stack.Screen
          name="ReserveStep"
          component={ReserveStep}
        />
        <Stack.Screen
          name="TimeSelectStep"
          component={TimeSelectStep}
        />
        <Stack.Screen
          name="ReserveConfirmStep"
          component={ReserveConfirmStep}
        />
        <Stack.Screen
          name="OrderEndStep"
          component={OrderEndStep}
        />
        <Stack.Screen
          name="ReviewStep"
          component={ReviewStep}
        />
      </Stack.Navigator>
    );
  }
}
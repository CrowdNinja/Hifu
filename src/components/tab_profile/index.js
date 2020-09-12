import React, { PureComponent } from 'react'

import { createStackNavigator } from '@react-navigation/stack';

import AuthStack from '../auth';
import LoadingScreen from '../common/indicator';

import AccountScreen from './account';
import ChargeScreen from './charge';
import ChargeResultScreen from './charge_complete'
import InfoScreen from './info';
import InfoAddressScreen from './info_address';
import AddressEditScreen from './addressEdit';
import SecurityScreen from './security';
import PasswordScreen from './security_password';
import PhoneScreen from './security_phone';
import CouponScreen from './coupon';
import PaymentPasswordScreen from './payment_password';
import AboutScreen from './about';
import TutorialScreen from './tutorial'
import NewsScreen from './news';
import NewsDetailScreen from './news_detail';

const Stack = createStackNavigator();

import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'
import {getStorage} from '../../config/storage'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);
  }

  render() {
    const {account} = this.context.state

    return (
      <Stack.Navigator
        headerMode="none"
        screenOptions={{
        }}
        initialRouteName={"AccountScreen"}
      >
        {account ? (
          <>
            <Stack.Screen
              name="AccountScreen"
              component={AccountScreen}
            />
            <Stack.Screen
              name="ChargeScreen"
              component={ChargeScreen}
            />
            <Stack.Screen
              name="ChargeResultScreen"
              component={ChargeResultScreen}
            />
            <Stack.Screen
              name="InfoScreen"
              component={InfoScreen}
            />
            <Stack.Screen
              name="InfoAddressScreen"
              component={InfoAddressScreen}
            />
            <Stack.Screen
              name="AddressEditScreen"
              component={AddressEditScreen}
            />
            <Stack.Screen
              name="SecurityScreen"
              component={SecurityScreen}
            />
            <Stack.Screen
              name="PasswordScreen"
              component={PasswordScreen}
            />
            <Stack.Screen
              name="PhoneScreen"
              component={PhoneScreen}
            />
            <Stack.Screen
              name="CouponScreen"
              component={CouponScreen}
            />
            <Stack.Screen
              name="PaymentPasswordScreen"
              component={PaymentPasswordScreen}
            />
            <Stack.Screen
              name="AboutScreen"
              component={AboutScreen}
            />
            <Stack.Screen
              name="TutorialScreen"
              component={TutorialScreen}
            />
            <Stack.Screen
              name="NewsScreen"
              component={NewsScreen}
            />
            <Stack.Screen
              name="NewsDetailScreen"
              component={NewsDetailScreen}
            />
          </>
        ) : (
          <Stack.Screen
            name="AuthStack"
            component={AuthStack}
          />
        )}
      </Stack.Navigator>
    );
  }
}
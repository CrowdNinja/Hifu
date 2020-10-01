import React, { PureComponent } from 'react'

import { createStackNavigator } from '@react-navigation/stack';

import InitScreen from './init';
import SignInScreen from './sign_in';
import SignUpScreen from './sign_up';
import TermScreen from './term'

const Stack = createStackNavigator();

export default class App extends PureComponent {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <Stack.Navigator
        headerMode="none"
        screenOptions={{
        }}
        initialRouteName={"InitScreen"}
      >
        <Stack.Screen
          name="InitScreen"
          component={InitScreen}
        />
        <Stack.Screen
          name="SignInScreen"
          component={SignInScreen}
        />
        <Stack.Screen
          name="SignUpScreen"
          component={SignUpScreen}
        />
        <Stack.Screen
          name="TermScreen"
          component={TermScreen}
        />
      </Stack.Navigator>
    );
  }
}
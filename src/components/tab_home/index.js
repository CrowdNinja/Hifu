import React, { PureComponent } from 'react'
import { createStackNavigator } from '@react-navigation/stack';

import HomeScreen from './home';
import QRScreen from './qr';
import SearchAreaScreen from './search_area';

import { UserContext } from '../../store/store'

const Stack = createStackNavigator();

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);
  }

  render() {
    return (
      <Stack.Navigator
        headerMode="none"
        screenOptions={{
        }}
        initialRouteName={'HomeScreen'}
      >
        <Stack.Screen
          name="HomeScreen"
          component={HomeScreen}
        />
        <Stack.Screen
          name="QRScreen"
          component={QRScreen}
        />
        <Stack.Screen
          name="SearchAreaScreen"
          component={SearchAreaScreen}
        />
      </Stack.Navigator>
    );
  }
}
import React, { PureComponent } from 'react'
import { createStackNavigator } from '@react-navigation/stack';

import ShopScreen from './shop';
import ShopDetailScreen from './shop_detail'
import ShopMenuScreen from './shop_menu';
import SearchKeywordScreen from './search_keyword'
import SearchResultScreen from './search_result'

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
      >
        <Stack.Screen
          name="ShopScreen"
          component={ShopScreen}
        />
        <Stack.Screen
          name="ShopDetail"
          component={ShopDetailScreen}
        />
        <Stack.Screen
          name="ShopMenuScreen"
          component={ShopMenuScreen}
        />
        <Stack.Screen
          name="SearchKeywordScreen"
          component={SearchKeywordScreen}
        />
        <Stack.Screen
          name="SearchResultScreen"
          component={SearchResultScreen}
        />
      </Stack.Navigator>
    );
  }
}
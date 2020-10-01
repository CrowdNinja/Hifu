import React from 'react';
import { AppRegistry } from 'react-native';

import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

import { Provider } from 'react-redux'

import Root from './components';
import { StateProvider } from './store/store'
import configureStore from './store'

const store = configureStore()
const Stack = createStackNavigator();

export default class App extends React.PureComponent {
  render () {
    return (
      <Provider store={store}>
        <StateProvider>
          <NavigationContainer>
            <Stack.Navigator headerMode="none">
              <Stack.Screen
                name="Root"
                component={Root}
              />
            </Stack.Navigator>
          </NavigationContainer>
        </StateProvider>
      </Provider>
    );
  }
}

AppRegistry.registerComponent('App', () => App);

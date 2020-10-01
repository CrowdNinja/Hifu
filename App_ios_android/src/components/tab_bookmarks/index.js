import React, { PureComponent } from 'react'
import { createStackNavigator } from '@react-navigation/stack';

import BookmarksScreen from './bookmarks';

import { UserContext } from '../../store/store'

const Stack = createStackNavigator();

export default class App extends PureComponent {
  static contextType = UserContext

  componentDidMount() {
    this._unsubscribe = this.props.navigation.addListener('focus', () => {
      const token = this.context.state.token
      if (!token) this.props.navigation.jumpTo("TabMypage")
    });
  }

  render() {
    return (
      <Stack.Navigator
        headerMode="none"
        screenOptions={{
        }}
      >
        <Stack.Screen
          name="BookmarksScreen"
          component={BookmarksScreen}
        />
      </Stack.Navigator>
    );
  }
}
import * as React from 'react';
import {
  SafeAreaView,
  Platform,
  StyleSheet
} from 'react-native';
import { createMaterialTopTabNavigator } from '@react-navigation/material-top-tabs';

import RTabReserve from './reserve'
import RTabUse from './use'

import TopBar from '../common/topbar';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext } from '../../store/store'

const Tab = createMaterialTopTabNavigator();

export default class MyTabs extends React.PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props)

    const params = props.route.params
    this.state = {
      initial: params ? params.initial : 'RTabAll'
    }
  }

  componentDidMount() {
    this._unsubscribe = this.props.navigation.addListener('focus', () => {
      const token = this.context.state.token
      if (!token) this.props.navigation.navigate("TabMypage")
    });
  }

  componentWillUnmount() {
    this._unsubscribe();
  }

  render () {
    const {initial} = this.state

    return (
      <SafeAreaView style={styles.container}>
        <TopBar 
          title="予約管理"
          hasBack={false}
        />
        <Tab.Navigator
          tabBarOptions={{
            activeTintColor: colors.primaryColor,
            inactiveTintColor: 'gray',
            scrollEnabled: true,
            tabStyle: {
              width: dimen(50)
            },
            indicatorStyle: {
              height: 2.5,
              backgroundColor: colors.primaryColor
            },
            style: {
              shadowColor: 'black',
              shadowOffset: { width: 1, height: 1 },
              shadowOpacity: 0.3,
              backgroundColor: 'white',
              shadowRadius: 1,
              elevation: 1,
            },
            labelStyle: {
              fontSize: dimen(3.5)
            }
          }}
          swipeEnabled={true}
          initialRouteName={initial}
        >

          <Tab.Screen
            name="RTabReserve"
            component={RTabReserve}
            options={{ tabBarLabel: '予約チケット' }}
          />
          <Tab.Screen
            name="RTabUse"
            component={RTabUse}
            options={{ tabBarLabel: '予約確認' }}
          />
        </Tab.Navigator>
      </SafeAreaView>
    )
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.primaryColor
  },
})
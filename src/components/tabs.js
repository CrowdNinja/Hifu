import React, { PureComponent } from 'react'
import {
  Alert,
  PermissionsAndroid,
  Platform,
  BackHandler,
  StyleSheet
} from 'react-native'
import { connect } from 'react-redux'
import SplashScreen from 'react-native-splash-screen'
import Geolocation from '@react-native-community/geolocation';
import FastImage from 'react-native-fast-image';

import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

import TabHome from './tab_home'
import TabBookmark from './tab_bookmarks'
import TabHistory from './tab_history'
import TabMypage from './tab_profile'

import {
  fetchShop,
  fetchBookmark
} from '../actions'
import { UserContext, SET_PROFILE, SET_LOCATION } from '../store/store';

import * as Api from '../apis/api'
import {getStorage, setStorage, KEY_INITIAL} from '../config/storage'

import colors from '../config/colors';
import { dimen } from '../config/dimen';

const ICON_HOME_ON = require('../../assets/images/tab_home_on.jpg');
const ICON_HEART_ON = require('../../assets/images/tab_heart_on.jpg');
const ICON_HISTORY_ON = require('../../assets/images/tab_history_on.jpg');
const ICON_MYPAGE_ON = require('../../assets/images/tab_mypage_on.jpg');
const ICON_HOME = require('../../assets/images/tab_home.jpg');
const ICON_HEART = require('../../assets/images/tab_heart.jpg');
const ICON_HISTORY = require('../../assets/images/tab_history.jpg');
const ICON_MYPAGE = require('../../assets/images/tab_mypage.jpg');
 
const Tab = createBottomTabNavigator();

class App extends PureComponent {
  static contextType = UserContext

  async componentDidMount() {
    BackHandler.addEventListener('hardwareBackPress', this.handleBackButton);

    const token = await getStorage()
    const notFirst = await getStorage(KEY_INITIAL)
    
    if (!notFirst && !token) {
      setStorage(true, KEY_INITIAL)
      this.props.navigation.push("FirstCoupon")
    }
    
    if (token) {
      const user = await Api.get_profile(token)

      this.props.fetchBookmark(token)
      this.context.dispatch({type: SET_PROFILE,
        nickname: user.nickname, token: user.token, account: user.account, avatar: user.avatar, money: user.money,
        address: user.address, pay_password1: user.pay_password1,
        square_customer_id: user.square_customer_id
      })
      setStorage(token)
    }

    if (Platform.OS === 'android') {
      const granted = await PermissionsAndroid.check( PermissionsAndroid.PERMISSIONS.ACCESS_FINE_LOCATION );
      if (granted == PermissionsAndroid.RESULTS.GRANTED) {
        this.getLocation()
      } else {
        const {latitude, longitude} = this.context.state
        this.props.fetchShop(latitude, longitude)
      }
    } else {
      this.getLocation()
    }

    SplashScreen.hide();
  }

  getLocation = () => Geolocation.getCurrentPosition(this.onSuccess, this.onError)
  onSuccess = (info) => {
    const {latitude, longitude} = info.coords
    this.context.dispatch({
      type: SET_LOCATION,
      latitude: latitude, longitude: longitude
    })
    this.props.fetchShop(latitude, longitude)
  }
  onError = (error) => {
    const {latitude, longitude} = this.context.state
    this.props.fetchShop(latitude, longitude)
    Alert.alert("位置情報を取得出来ません")
  }

  componentWillUnmount() {
    BackHandler.removeEventListener('hardwareBackPress', this.handleBackButton);
  }

  handleBackButton = () => {
    Alert.alert(
      '確認',
      'アプリを終了しますか？', [{
          text: 'キャンセル',
          onPress: () => {},
          style: 'cancel'
      }, {
          text: '終了',
          onPress: () => BackHandler.exitApp()
      }, ], {
          cancelable: false
      }
    )
    return true;
  }

  render() {
    const isAuthed = this.context.state.account != null

    return (
      <Tab.Navigator
        tabBarOptions={{
          inactiveBackgroundColor: '#FFF',
          // activeBackgroundColor: '#F8F7F7',
          activeTintColor: colors.primaryColor,
          inactiveTintColor: 'gray',
          labelStyle: {
            fontSize: dimen(3)
          },
          tabStyle: {
          },
          style: {
            backgroundColor: '#FFF',
          },
        }}
        screenOptions={({ route }) => ({
          tabBarIcon: ({ focused, color, size }) => {
            let iconName;
            switch (route.name) {
              case 'TabHome':
                return <FastImage source={focused ? ICON_HOME_ON : ICON_HOME} style={styles.icon_tab} />
              case 'TabBookmark':
                return <FastImage source={focused ? ICON_HEART_ON : ICON_HEART} style={styles.icon_tab} resizeMode='contain'/>
              case 'TabHistory':
                return <FastImage source={focused ? ICON_HISTORY_ON : ICON_HISTORY} style={styles.icon_tab} />
              case 'TabMypage':
                return <FastImage source={focused ? ICON_MYPAGE_ON : ICON_MYPAGE} style={styles.icon_tab} />
            }
          }
        })}
        initialRouteName={'TabHome'}
      >
        <Tab.Screen
          name="TabHome"
          component={TabHome}
          options={{
            tabBarLabel: 'トップ',
          }}
        />
        {isAuthed &&
          <Tab.Screen
            name="TabBookmark"
            component={TabBookmark}
            options={{
              tabBarLabel: 'ブックマーク',
            }}
            disabled={true}
          />
        }
        {isAuthed &&
          <Tab.Screen
            name="TabHistory"
            component={TabHistory}
            options={{
              tabBarLabel: '予約管理',
            }}
          />
        }
        <Tab.Screen
          name="TabMypage"
          component={TabMypage}
          options={{
            tabBarLabel: 'マイページ',
          }}
        />      
      </Tab.Navigator>
    );
  }
}

function mapStateToProps (state) {
  return {
    userReducer: state.userReducer,
    shopReducer: state.shopReducer
  }
}
function mapDispatchToProps (dispatch) {
  return {
    fetchShop: (lat, lng) => dispatch(fetchShop(lat, lng)),
    fetchBookmark: (token) => dispatch(fetchBookmark(token)),
  }
}
export default connect(
  mapStateToProps,
  mapDispatchToProps
)(App)

const styles = StyleSheet.create({
  icon_tab: {
    width: dimen(3.5),
    height: dimen(3.5)
  },
})
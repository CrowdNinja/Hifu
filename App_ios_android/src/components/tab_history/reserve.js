import React, {PureComponent} from 'react';
import {
  View,
  StyleSheet,
  FlatList,
  RefreshControl,
} from 'react-native';

import Item from './_item';
import Indicator from '../common/indicator'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext } from '../../store/store'
import * as Api from '../../apis/api'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      loading: true,
      trades: []
    };
  }

  componentDidMount() {
    this.unsubscribe = this.props.navigation.addListener('focus', () => {
      this.api_get_trades()
    });
  }

  componentWillUnmount() {
    this.unsubscribe()
  }

  onRefresh = () => {
    this.setState({loading: true})
    this.api_get_trades()
  }

  async api_get_trades() {
    const {token} = this.state
    const trades = await Api.get_trade_list(token, 1)

    this.setState({trades, loading: false})
  }

  render() {
    const {trades, loading} = this.state;

    return (
      <View style={styles.container}>
        <FlatList
          refreshControl={
            <RefreshControl
              refreshing={loading}
              onRefresh={this.onRefresh}
              tintColor='gray'
            />
          }
          data={trades}
          initialNumToRender={10}
          renderItem={({item, index}) => <Item key={index} item={item} navigation={this.props.navigation} kind={1}/> }
          keyExtractor={(_, index) => `${index}`}
          contentInset={{ bottom: 30 }}
        />
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
})


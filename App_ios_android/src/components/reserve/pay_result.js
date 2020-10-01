import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Alert,
} from 'react-native';

import ModalFinished from '../common/modal_payment_end'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  constructor(props) {
    super(props)

    this.state = {
      visible: true
    }
  }
  goOrder = () => {
    this.setState({visible: false})
    this.props.navigation.navigate("TabHistory", {initial: 'RTabReserve'})
  }
  goReserve = () => {
    this.setState({visible: false})
    this.props.navigation.push("ReserveStep")
  }

  render() {
    const {visible} = this.state
    const {status} = this.props.route.params

    return (
      <View style={styles.container}>
        {(status && visible) && 
          <ModalFinished
            onReserve={this.goReserve}
            onOrder={this.goOrder}
          />
        }

        {!status &&
          Alert.alert('購入失敗しました。')
        }
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1
  }
});

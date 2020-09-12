import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
} from 'react-native';
import moment from 'moment';
import TopBar from '../common/topbar';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);

    this.state = {
      notification: props.route.params.notification
    };
  }

  render() {
    const {
      notification
    } = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title="店舗からのご連絡"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        <View style={styles.box}>
          <View style={styles.header}>
            <Text style={styles.txt_date}>
              {moment(notification.ctime).format('M月D日HH:mm')}
            </Text>
            <Text style={styles.txt_title}>{notification.title}</Text>
          </View>
          <Text style={styles.txt_content}>{notification.content}</Text>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1
  },
  box: {
    flex: 1,
    margin: dimen(3),
    elevation: 1,
    shadowColor: 'black',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 1,
    backgroundColor: 'white',
    borderRadius: dimen(3),
    padding: dimen(3)
  },
  header: {
    borderBottomWidth: 1,
    borderBottomColor: 'lightgray',
    margin: 0,
    padding: 0
  },
  txt_title: {
    fontSize: dimen(4.5),
    marginTop: dimen(3),
  },
  txt_content: {
    flex: 1,
    fontSize: dimen(3.5),
    lineHeight: dimen(4),
    paddingTop: dimen(3)
  },
  txt_date: {
    textAlign: 'right',
    fontSize: dimen(3.5),
    color: 'lightgray'
  }
});
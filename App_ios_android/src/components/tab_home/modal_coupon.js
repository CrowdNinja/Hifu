import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import Modal from 'react-native-modal';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  render() {
    const {navigation} = this.props;

    return (
      <Modal isVisible={true} animationType="fade">
        <View style={styles.container}>
          <Text style={styles.txt_head}>クーポンを取得しました</Text>
          <Text style={styles.txt_body}>マイページのクーポン受取履歴からご確認ください</Text>
          <TouchableOpacity style={styles.btn}
            onPress={() => navigation.goBack()}
          >
            <Text style={styles.txt_btn}>閉じる</Text>
          </TouchableOpacity>
        </View>
      </Modal>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    backgroundColor: 'white',
    borderRadius: dimen(4),
    marginHorizontal: dimen(5),
    marginVertical: SCREEN_HEIGHT * 0.25,
    alignItems: 'center',
    justifyContent: 'space-around',
    padding: dimen(3)
  },
  txt_head: {
    fontSize: dimen(5.5),
    fontWeight: 'bold',
    color: colors.primaryColor
  },
  txt_body: {
    fontSize: dimen(4.5),
    lineHeight: dimen(7),
    color: colors.textRed,
    textAlign: 'center'
  },
  btn: {
    width: '90%',
    height: dimen(10),
    backgroundColor: colors.primaryColor,
    borderRadius: dimen(5),
    alignItems: 'center',
    justifyContent: 'center',
    shadowColor: 'gray',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
    elevation: 4,
  },
  txt_btn: {
    color: 'white',
    fontSize: dimen(4)
  }
});

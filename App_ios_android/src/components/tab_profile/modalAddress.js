import React, {PureComponent} from 'react';
import {
  StyleSheet,
  TextInput,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import Modal from 'react-native-modal';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  constructor(props) {
    super(props);

    this.state = {
    };
  }

  render() {
    const {} = this.props;

    return (
      <Modal isVisible={true} animationType="fade">
        <View style={styles.wrapperStyle}>
          <View>
            <Text style = {styles.iconTextStyle}>
              このアドレスを削除します。{"\n"}よろしいですか？
            </Text>
          </View>
          <View style={styles.buttonGroupStyle}>
            <TouchableOpacity
              onPress = {() => this.props.onDelete(false) }
              style={styles.content_btn}
            >
              <Text style = {[styles.btnStyle1, styles.btn]}>
                キャンセル
              </Text>
            </TouchableOpacity>
            <TouchableOpacity
              onPress = {() => this.props.onDelete(true) }
              style={styles.content_btn}
            >
              <Text style = {[styles.btnStyle2, styles.btn]}>
                確定
              </Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    );
  }
}

const styles = StyleSheet.create({
  fullStyle: {
  },
  wrapperStyle: {
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2),
    overflow: 'hidden'
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(4),
    lineHeight: dimen(4.5),
    paddingVertical: 30,
    paddingHorizontal: 30
  },
  content_btn: {
    flex: 1,
  },
  btn: {
    height: dimen(12),
    lineHeight: dimen(12),
    fontSize: dimen(4),
    textAlign: "center",
  },
  btnStyle2: {
    backgroundColor:  colors.primaryColor,
    color: 'white',
  },
  btnStyle1: {
    backgroundColor:  colors.lightGrayColor,
  },
  buttonGroupStyle: {
    flexDirection: "row",
  }
});

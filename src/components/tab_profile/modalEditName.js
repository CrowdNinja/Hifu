import React, {PureComponent} from 'react';
import {
  StyleSheet,
  TextInput,
  View,
  Text,
  TouchableOpacity,
  TouchableWithoutFeedback,
  Keyboard
} from 'react-native';
import Modal from 'react-native-modal';

import {dimen, percent} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  constructor(props) {
    super(props);

    this.state = {
      value: props.value
    };
  }

  render() {
    const {value} = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <Modal isVisible={true} animationType="fade">
        <View style={styles.wrapperStyle}>
          <Text style = {styles.iconTextStyle}>お名前（フルネーム）</Text>
          <TextInput
            style={styles.profileInputStyle}
            value={value}
            onChangeText={text => this.setState({value: text})}
          />
          <View style={styles.buttonGroupStyle}>
            <TouchableOpacity style={styles.btnStyle1} onPress = {() => this.props.onClose() }>
              <Text style = {styles.registerText1Style}>キャンセル</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.btnStyle2} onPress = {() => this.props.onClose(value) }>
              <Text style = {styles.registerTextStyle}>確定</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  wrapperStyle: {
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(2),
    paddingTop: dimen(6),
    overflow: "hidden"
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(5),
    paddingLeft: percent(6),
    textAlign: 'left',
    lineHeight: dimen(8.4),
    textAlignVertical: "center",
    textAlign: 'left',
  },
  btnStyle2: {
    height: dimen(12),
    width: '50%',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
  },
  btnStyle1: {
    height: dimen(12),
    width: '50%',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.lightGrayColor,
  },
  registerTextStyle : {
    color: 'white',
    fontSize: dimen(4)
  },
  registerText1Style : {
    color: colors.textColor,
    fontSize: dimen(3.5)
  },
  profileInputStyle: {
    fontSize: dimen(3.5),
    paddingTop: dimen(2.8),
    paddingBottom: dimen(2.8),
    paddingLeft: dimen(2),
    borderWidth: 1,
    color: colors.blackColor,
    borderColor: colors.grayColor,
    borderRadius: dimen(2),
    marginHorizontal: dimen(5),
    marginTop: dimen(2)
  },
  buttonGroupStyle: {
    flexDirection: "row",
    marginTop: dimen(7.6)
  }
});

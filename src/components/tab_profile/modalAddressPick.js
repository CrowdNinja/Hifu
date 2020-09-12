import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity
} from 'react-native';
import Modal from 'react-native-modal';
import {Picker} from '@react-native-community/picker';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  constructor(props) {
    super(props);

    this.state = {
      mode: props.mode,
      value: props.value,
      values: props.values,
    };
  }

  render() {
    const {mode, value, values} = this.state
    const {onClose} = this.props

    return (
      <Modal isVisible={true} animationType="fade">
        <View style={styles.fullStyle}>
          <View style={styles.buttonGroupStyle}>
            <TouchableOpacity style={styles.action_button} onPress={onClose(mode, null)}>
              <Text style={styles.action_button_text}>取消</Text>
            </TouchableOpacity>
            <Text style={styles.address_text}>都道府県</Text>
            <TouchableOpacity style={styles.action_button} onPress={onClose(mode, value)}>
              <Text style = {styles.action_button_text}>確定</Text>
            </TouchableOpacity>
          </View>

          <View style={styles.wrapperStyle}>
            <Picker
              selectedValue={value}
              style={styles.picker}
              onValueChange={(itemValue, itemIndex) =>
                this.setState({value: itemValue})}>
                {values.map((val, index) => {
                  return (
                    <Picker.Item key={index} 
                      color={value == val[1] ? colors.primaryColor : 'gray'}
                      label={val[1]} value={val[1]}
                    />
                  )
                })}
            </Picker>
          </View>          
        </View>
      </Modal>
    );
  }
}

const styles = StyleSheet.create({
  fullStyle: {
    position: "absolute",
    width: dimen(100),
    left: dimen(-5),
    paddingTop: dimen(2),
    height: SCREEN_HEIGHT*0.34,
    bottom: 0,
    backgroundColor: colors.whiteColor
  },
  wrapperStyle: {
    flexDirection: 'row',
    alignItems: "center",
    justifyContent: 'center',
    overflow: "hidden",
  },
  action_button: {
    height: dimen(12),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.whiteColor,
    color: colors.primaryColor,
    fontSize: 20,
  },
  action_button_text : {
    color: colors.primaryColor,
    padding: dimen(2),
    borderWidth: 1,
    borderRadius: 3,
    borderColor: colors.primaryColor,
    fontSize: dimen(4.5)
  },
  buttonGroupStyle: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
    borderBottomColor: colors.grayColor,
    borderBottomWidth: 1,
    paddingBottom: dimen(2),
    paddingLeft: percent(3),
    paddingRight: percent(3),
  },
  address_text: {
    fontSize: dimen(5)
  },
  picker: {
    flex: 1
  },
  picker_item: {
    color: colors.primaryColor
  }
});

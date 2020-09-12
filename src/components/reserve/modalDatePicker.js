import React, {PureComponent} from 'react';
import {
  StyleSheet,
  Image,
  View,
  Text,
  TouchableOpacity
} from 'react-native';
import {Picker} from '@react-native-community/picker';
import Modal from 'react-native-modal';
import _ from 'lodash';

const ICON_CLOSE = require('../../../assets/images/icon_close.png');

import {SCREEN_WIDTH, SCREEN_HEIGHT, dimen, percent} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  constructor(props) {
    super(props);

    var y = _.range(2000, new Date().getFullYear() + 10)
    var m = _.range(1, 13)

    this.state = {
      years: y,
      months: m,
      selectedYear: this.props.date.year(),
      selectedMonth: this.props.date.month(),
      ayears: this.convertPickerData(y, '年'),
      amonths: this.convertPickerData(m, '月'),
    };
  }

  convertPickerData = (list) => {
    return list.map(i => {
      return {
        label: i, 
        value: i,
        key: i,
      }
    })
  }

  pad = (num, size) => { return ('000' + num).slice(size * -1); }

  onYearChanged = (value) => {
    this.setState({
      selectedYear: value,
    });
  }

  onMonthChanged = (value) => {
    this.setState({
      selectedMonth: value,
    });
  }
  
  ok = () => {
    this.props.onDateChanged(new Date(this.state.selectedYear, this.state.selectedMonth - 1, 1));
  }

  render() {
    const {years, months, selectedYear, selectedMonth} = this.state

    return (
      <Modal 
        isVisible={this.props.isVisible} 
        animationType="fade"
        style={styles.container}
      >
        <View style={styles.content}>
          <Text style = {styles.title}>
            年と月を選択
          </Text>
          <Text style = {styles.date}>
            { this.props.date.format('YYYY年MM月') }
          </Text>
          <View style={styles.pickers}>
            <View style={{...styles.divider, marginRight: dimen(6)}}/>
            <Picker
              selectedValue={selectedYear}
              style={styles.picker}
              itemStyle={styles.pickerItem}
              onValueChange={this.onYearChanged}>
              { years.map((year, i) =>
                <Picker.Item label={year.toString()} value={year} key={i} color={year == selectedYear ? colors.primaryColor : colors.textColor} />
              )}
            </Picker>
            <Text style={{ marginRight: dimen(8), color: colors.primaryColor }}>年</Text>
            <Picker
              selectedValue={selectedMonth}
              style={styles.picker}
              itemStyle={styles.pickerItem}
              onValueChange={this.onMonthChanged}>
              {months.map((month, i) =>
                <Picker.Item label={this.pad(month, 2)} value={month} key={i} color={month == selectedMonth ? colors.primaryColor : colors.textColor} />
              )}
            </Picker>
            <Text style={{color: colors.primaryColor}}>月</Text>
            <View style={{...styles.divider, marginLeft: dimen(6)}}/>
          </View>
          <View style={styles.buttonGroupStyle}>
            <TouchableOpacity style={styles.btn} onPress={this.props.cancel}>
              <Text style={styles.btnTitle}>キャンセル</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.btn} onPress={this.ok}>
              <Text style={styles.btnTitle}>決定</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  content: {
    borderRadius: dimen(2),
    backgroundColor: colors.whiteColor,
  },
  title: {
    marginTop: dimen(5),
    color: colors.blackColor,
    fontSize: dimen(5),
    textAlign: 'center',
    lineHeight: dimen(6),
  },
  date: {
    color: colors.gray128,
    fontSize: dimen(3.5),
    textAlign: 'center',
    lineHeight: dimen(6),
  },
  buttonGroupStyle: {
    borderTopColor: colors.gray230,
    borderTopWidth: 0.5,
    marginTop: dimen(5),
    flexDirection: 'row',
    justifyContent: 'space-between'
  },
  btn: {  
    width: '50%',
    height: dimen(14),
  },
  btnTitle: {
    textAlign: 'center',
    fontSize: dimen(4),
    color: colors.blackColor,
    lineHeight: dimen(14),
  },
  pickers: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center'
  },
  picker: {
    width: dimen(15),
    backgroundColor: 'white',
  },
  pickerItem: {
    fontSize: dimen(3.5),
    color: colors.black,
  },
  divider: {
    width: 3,
    height: dimen(10),
    backgroundColor: colors.primaryColor
  }
});

import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  Alert,
  ScrollView
} from 'react-native';
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faCheckCircle } from '@fortawesome/free-regular-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator';

import * as Api from '../../apis/api'
import { UserContext, SET_PHONE } from '../../store/store'

import {dimen} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);

    this.state = {
      agreements: [],
      allChecked: false,
      account: props.route.params.account
    };
  }

  componentDidMount() {
    this.api_()
  }

  onCheck = (index, flag = true) => {
    const {agreements} = this.state
    agreements[index].checked = flag
    this.setState({agreements}, () => {
      if (agreements.filter(d => d.checked == true).length == agreements.length) {
        this.setState({allChecked: true})
      } else {
        this.setState({allChecked: false})
      }
    })
  }

  onSubmit = () => {
    if (this.state.allChecked) {
      this.context.dispatch({type: SET_PHONE, account: this.state.account})
      this.props.navigation.jumpTo("TabHome")
    } else {
      Alert.alert("同意してください")
    }
  }

  api_ = async () => {
    const agreements = await Api.get_agreement()
    this.setState({agreements})
  }

  render() {
    const {agreements} = this.state
    return (
      <View style={styles.container}>
        <TopBar
          title="ご利用規約・個人情報保護方針・同意書"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
          hasBack={false}
        />
        <ScrollView nestedScrollEnabled={true}>
          {agreements.map((agreement, index) =>
            <Item item={agreement} key={index} index={index} onCheck={this.onCheck} />
          )}

          <View style={styles.groups}>
            <TouchableOpacity style = {styles.btn_cancel}
              onPress={() => this.props.navigation.goBack()}
            >
              <Text style = {styles.txt_cancel}>戻る</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.btn_ok}
              onPress={this.onSubmit}
            >
              <Text style = {styles.txt_ok}>全てに同意します</Text>
            </TouchableOpacity>
          </View>
        </ScrollView>
      </View>
    );
  }
}

class Item extends PureComponent {
  constructor(props) {
    super(props)

    this.state = {checked: false}
  }

  onCheck = () => {
    const {checked} = this.state
    this.setState({checked: !checked})
    this.props.onCheck(this.props.index, !checked)
  }

  render() {
    const {checked} = this.state
    const {item} = this.props

    return (
      <View style={styles.item}>
        <Text style={styles.txt_title}>
          {item.title}
        </Text>
        <View style={styles.scrollview}>
        <ScrollView nestedScrollEnabled={true}>
        <Text style={styles.txt_detail}>
          {item.content}
        </Text>
        </ScrollView>
        </View>
        
        <TouchableOpacity style={checked ? [styles.btn, styles.btn_enable] : styles.btn} onPress={this.onCheck}>
          <FontAwesomeIcon icon={faCheckCircle} size={dimen(4)} color={checked ? 'white' : colors.primaryColor} />
          <Text style={checked ? [styles.txt_btn, styles.txt_btn_enable] : styles.txt_btn}>同意します</Text>
        </TouchableOpacity>
      </View>
    )
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'white',
  },
  item: {
    paddingHorizontal: dimen(3),
    paddingTop: dimen(2)
  },
  txt_title: {
    fontSize: dimen(4.5),
    fontWeight: 'bold',
    paddingVertical: dimen(4),
  },
  scrollview: {
    borderRadius: dimen(1.5),
    borderWidth: 1,
    borderColor: 'lightgray',
    height: dimen(70),
    padding: dimen(2),
  },
  txt_detail: {
    color: 'gray',
    lineHeight: dimen(4.2),
    fontSize: dimen(3.5),
    flexShrink: 1
  },
  btn: {
    width: dimen(40),
    height: dimen(11),
    marginTop: dimen(3),
    borderRadius: dimen(1),
    borderWidth: 1,
    borderColor: 'lightgray',
    alignSelf: 'center',
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center'
  },
  btn_enable: {
    borderWidth: 0,
    backgroundColor: colors.primaryColor
  },
  txt_btn: {
    fontSize: dimen(4),
    color: colors.primaryColor,
    fontWeight: 'bold',
    marginLeft: dimen(2.5)
  },
  txt_btn_enable: {
    color: 'white'
  },
  groups: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    alignItems: 'center',
    paddingVertical: dimen(25)
  },
  btn_cancel: {
    width: dimen(40),
    height: dimen(11),
    borderRadius: dimen(1),
    borderWidth: 1,
    borderColor: 'lightgray',
    alignItems: 'center',
    justifyContent: 'center',
    borderColor: colors.primaryColor
  },
  txt_cancel: {
    fontSize: dimen(4),
    color: colors.primaryColor,
  },
  btn_ok: {
    width: dimen(40),
    height: dimen(11),
    borderRadius: dimen(1),
    backgroundColor: colors.primaryColor,
    alignItems: 'center',
    justifyContent: 'center',
  },
  txt_ok: {
    fontSize: dimen(4),
    color: 'white',
  },
});

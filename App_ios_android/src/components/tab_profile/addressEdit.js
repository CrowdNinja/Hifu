import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  TouchableWithoutFeedback,
  Keyboard,
  TextInput,
  Alert
} from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronRight } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ModalAddressPick from './modalAddressPick'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import {PREFECTURES, getProvinceID, ERR_DURATION} from '../../config/constant'
import { UserContext } from '../../store/store'
import * as Api from '../../apis/api'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    const address = props.route.params.address
    this.state = {
      token: context.state.token,
      mode: props.route.params.mode, // 0 add, 1 edit
      loading: true,
      id: address.id,
      name: address.name,
      phone: address.phone,
      province: address.province,
      city: address.city,
      address: address.address,
      area: address.area,

      showDialog: false,
      modeDialog: 0,
      provinceId: '01',
      cities: []
    };
  }

  async componentDidMount() {
    var provinceId = getProvinceID(this.state.province)
    const cities = await Api.get_cities(provinceId)

    this.setState({loading: false, cities, provinceId})
  }

  onCloseModal = (mode, value) => () => {
    if (value) {
      if (mode) {
        this.setState({showDialog: false, city: value})
      } else {
        this.setState({showDialog: false}, () => {
          const provinceId = getProvinceID(value)
          setTimeout(() => 
            this.setState({loading: true}, () =>
              this.api_set_prefecture(provinceId, value)
            )
          , ERR_DURATION)
        })
      }
    } else {
      this.setState({showDialog: false})
    }
  }
  async api_set_prefecture(provinceId, province) {
    const cities = await Api.get_cities( provinceId )
    this.setState({
      loading: false,
      province,
      city: '',
      cities,
      provinceId
    })
  }
  async api_set_address() {
    const {token, mode, id, name, phone, province, city, address, area} = this.state;
    if (mode) {
      const result = await Api.edit_address(token, id, name, phone, province, city, area, address)
      
      this.setState({loading: false}, () => {
        setTimeout(() => {
          if (result.code == 1) {
            Alert.alert('住所変更しました')
          } else {
            Alert.alert('住所変更に失敗しました')
          }
        }, ERR_DURATION)
      })
    } else {
      const result = await Api.add_address(token, name, phone, province, city, area, address)
      
      this.setState({loading: false}, () => {
        setTimeout(() => {
          if (result.code == 1) {
            Alert.alert('住所追加しました')
          } else {
            Alert.alert('住所追加に失敗しました')
          }
        }, ERR_DURATION)
      })
    }
  }
  onSave = () => {
    this.setState({loading: true})
    this.api_set_address()
  }

  render() {
    const {
      loading, name, phone, province, city, address, area, showDialog, modeDialog, cities
    } = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <View style={styles.container}>
        <TopBar
          title="住所追加"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {loading && <Indicator/> }

        {showDialog &&
          <ModalAddressPick
            mode={modeDialog}
            value={modeDialog ? city : province}
            values={modeDialog ? cities : PREFECTURES}
            onClose={this.onCloseModal}
          />
        }

        <View style={styles.item}>
          <Text style={styles.label}>氏       名：</Text>
          <TextInput style={styles.textedit} value={name}
            onChangeText={text => this.setState({name: text}) }
          />
        </View>
        <View style={styles.item}>
          <Text style={styles.label}>電話番号：</Text>
          <TextInput style={styles.textedit} value={phone}
            onChangeText={text => this.setState({phone: text}) }
            keyboardType='numeric'
          />
        </View>
        <View style={styles.item}>
          <Text style={styles.label}>都道府県：</Text>
          <TouchableOpacity style={styles.view_address}
            onPress={() => this.setState({showDialog: true, modeDialog: 0}) }
          >
            <Text style={styles.textedit}>{province}</Text>
            <FontAwesomeIcon icon={faChevronRight} color='gray' />
          </TouchableOpacity>
        </View>
        <View style={styles.item}>
          <Text style={styles.label}>市区町村：</Text>
          <TouchableOpacity style={styles.view_address}
            onPress={() => this.setState({showDialog: true, modeDialog: 1}) }
          >
            <Text style={styles.textedit}>{city}</Text>
            <FontAwesomeIcon icon={faChevronRight} color='gray' />
          </TouchableOpacity>
        </View>

        <TouchableOpacity style={styles.part3}
          onPress={this.onSave}
        >
          <View style={styles.block1_part3}>
            <Text style={styles.text_block1_part3}>保存する</Text>
          </View>
        </TouchableOpacity>
      </View>
      </TouchableWithoutFeedback>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  item: {
    backgroundColor: 'white',
    height: dimen(14),
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    borderBottomColor: 'lightgray',
    borderBottomWidth: 0.3,
    paddingHorizontal: dimen(3)
  },
  label: {
    fontSize: dimen(4),
    fontWeight: 'bold',
    color: colors.backColor
  },
  textedit: {
    marginLeft: 8,
    paddingVertical: 5,
    flex: 1,
    color: colors.blackColor,
    fontSize: dimen(3.5),
    padding: 0,
    margin: 0,
    justifyContent: 'center',
    alignItems: 'center'
  },
  view_address: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
  },
  part3: {
    position: "absolute",
    bottom:0, left: 0, right: 0,
    height: dimen(16),
    paddingVertical: dimen(3),
    paddingHorizontal: dimen(5),
    backgroundColor: colors.whiteColor
  },
  block1_part3: {
    backgroundColor: colors.primaryColor,
    textAlign: "center",
    borderRadius: dimen(6),
    overflow: "hidden"
  },
  text_block1_part3: {
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(10),
    fontSize: dimen(5)
  },
});


import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  FlatList,
  RefreshControl,
} from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faEdit, faTrashAlt, faCheckCircle } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ModalAddress from './modalAddress'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext } from '../../store/store'
import * as Api from '../../apis/api'
import Address from '../../models/address';

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      loading: true,
      addresses: [],
      showModalDelete: false,
      selectedIndex: -1
    };

    this.onDelete = this.onDelete.bind(this)
    this.setDefault = this.setDefault.bind(this)
    this.renderItem = this.renderItem.bind(this)
    this.onRefresh = this.onRefresh.bind(this)
  }

  componentDidMount() {
    this.api_get_address()
    this._unsubscribe = this.props.navigation.addListener('focus', () => {
      this.api_get_address()
    });
  }

  componentWillUnmount() {
    this._unsubscribe();
  }

  onDelete(isDelete) {
    if (isDelete) {
      this.setState({showModalDelete: false}, () => {
        setTimeout(() => {
          this.setState({loading: true})
          this.api_delete()
        }, 500)
      })
      
    } else {
      this.setState({showModalDelete: false})
    }
  }

  onRefresh() {
    this.api_get_address()
  }

  setDefault(index) {
    const {addresses} = this.state
    this.setState({selectedIndex: index, loading: true})
    this.api_set_default(addresses[index].id)
  }

  async api_get_address() {
    const {token} = this.state
    var selectedIndex = -1
    const addresses = await Api.get_user_address(token)
    addresses.map((d, i) => {
      if (d.is_default == 1) selectedIndex =  i
    })
    this.setState({addresses, selectedIndex, loading: false})
  }

  async api_set_default(id) {
    const {token} = this.state
    await Api.set_default_address(token, id)
    this.setState({loading: false})
  }

  async api_delete() {
    const {token} = this.state
    const {addresses, selectedIndex} = this.state
    await Api.delete_address(token, addresses[selectedIndex].id)
    const newAddresses = [...addresses]
    newAddresses.splice(selectedIndex, 1)

    this.setState({addresses: newAddresses, loading: false})
  }

  renderItem(address, index) {
    const {selectedIndex} = this.state

    return (
      <View key={index} style={styles.item}>
        <TouchableOpacity style={styles.item_content}
          onPress={() => this.setDefault(index) }
        >
          <FontAwesomeIcon icon={faCheckCircle} size={dimen(4)} color={selectedIndex == index ? colors.primaryColor : 'lightgray'} />
          <View style={styles.content_text}>
            <Text style={styles.txt_title}>
              {`${address.name} ${address.phone}`}
            </Text>
            <Text style={styles.txt_description}>
            {`${address.province} ${address.city}`}
            </Text>
          </View>
        </TouchableOpacity>

        <View style={styles.item_btns}>
          <TouchableOpacity style={styles.item_btn}
            onPress={() => this.props.navigation.push("AddressEditScreen", {address: address, mode: 1}) }
          >
            <FontAwesomeIcon icon={faEdit} size={dimen(4)} color={colors.textColor} />
            <Text style={styles.btn_txt}>編集</Text>
          </TouchableOpacity>
          <TouchableOpacity style={styles.item_btn}
            onPress={() => this.setState({showModalDelete: true, selectedIndex: index}) }
          >
            <FontAwesomeIcon icon={faTrashAlt} size={dimen(4)} color={colors.textColor} />
            <Text style={styles.btn_txt}>削除</Text>
          </TouchableOpacity>
        </View>
      </View>
    )
  }

  render() {
    const {
      loading, addresses, showModalDelete, selectedIndex
    } = this.state

    return (
      <View style={styles.wrapper}>
        {showModalDelete && 
          <ModalAddress onDelete={this.onDelete} />
        }

        <TopBar
          title="住所一覧"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        <FlatList
          refreshControl={
            <RefreshControl
              refreshing={loading}
              onRefresh={this.onRefresh}
              tintColor='gray'
            />
          }
          data={addresses}
          extraData={addresses}
          renderItem={({item, index}) => this.renderItem(item, index) }
          keyExtractor={(_, index) => `${index}`}
          contentInset={{ bottom: 30 }}
        />

        <TouchableOpacity style={styles.part3}
          onPress={() => this.props.navigation.push("AddressEditScreen", {address: new Address(), mode: 0}) }
        >
          <View style={styles.block1_part3}>
            <Text style={styles.text_block1_part3}>住所追加</Text>
          </View>
        </TouchableOpacity>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  wrapper: {
    flex: 1,
    backgroundColor: colors.lightGrayColor
  },
  part3: {
    position: "absolute",
    bottom:0, left: 0, right: 0,
    height: dimen(16),
    paddingHorizontal: dimen(5),
    paddingVertical: dimen(3),
    backgroundColor: colors.whiteColor
  },
  block1_part3: {
    textAlign: "center",
    borderRadius: dimen(5),
    backgroundColor: colors.primaryColor,
  },
  text_block1_part3: {
    color: colors.whiteColor,
    textAlign: "center",
    lineHeight: dimen(10),
    fontSize: dimen(5)
  },
  item: {
    backgroundColor: 'white',
    marginBottom: dimen(3)
  },
  item_content: {
    flexDirection: 'row',
    alignItems: 'center',
    borderBottomColor: 'lightgray',
    borderBottomWidth: 0.5,
    paddingVertical: dimen(2),
    paddingHorizontal: dimen(3)
  },
  content_text: {
    flexShrink: 1,
    marginLeft: dimen(3)
  },
  txt_title: {
    fontSize: dimen(3.7),
    fontWeight: 'bold',
  },
  txt_description: {
    fontSize: dimen(3.5),
  },
  item_btns: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 10
  },
  item_btn: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
    justifyContent: 'center',
    borderRightWidth: 0.5,
    borderRightColor: 'lightgray'    
  },
  btn_txt: {
    fontSize: dimen(3.5),
    marginTop: 2,
    marginLeft: dimen(2),
  }
});

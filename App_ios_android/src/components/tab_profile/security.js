import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
} from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronRight } from '@fortawesome/free-solid-svg-icons';

import Indicator from '../common/indicator'
import TopBar from '../common/topbar';
import ModalContact from '../common/modalCall'

import { dimen } from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext } from '../../store/store'
import * as Api from '../../apis/api'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);

    this.state = {
      loading: false,
      showModalContact: false,
      phone: ''
    };

  }

  onClose = () => {
    this.setState({showModalContact: false})
  }
  onCall = async () => {
    this.setState({loading: true})
    this.api_()
  }

  api_ = async () => {
    const response = await Api.about()
    this.setState({
      phone: response.phone,
      loading: false
    }, () =>
      setTimeout(() => this.setState({showModalContact: true}), 300)
    )
  }


  render() {
    const account = this.context.state.account
    const {loading, phone, showModalContact} = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title="アカウント、セキュリティ"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {loading && <Indicator/> }

        {showModalContact &&
          <ModalContact
            phone={phone}
            onClose={this.onClose}
          />
        }

        <ScrollView>
          <TouchableOpacity style={styles.item}
            onPress={() => this.props.navigation.push("PasswordScreen")}
          >
            <Text style={styles.item_txt}>ログインパスワード</Text>
            <View style={styles.item_sub}>
              <FontAwesomeIcon icon={faChevronRight} color={'lightgray'} />
            </View>
          </TouchableOpacity>
          <TouchableOpacity style={styles.item}
            onPress={() => this.props.navigation.push("PhoneScreen")}
          >
            <Text style={styles.item_txt}>携帯電話番号の変更</Text>
            <View style={styles.item_sub}>
              <Text style={styles.item_sub_txt}>{account}</Text>
              <FontAwesomeIcon icon={faChevronRight} color={'lightgray'} />
            </View>
          </TouchableOpacity>
          <TouchableOpacity style={styles.item}
            onPress={this.onCall}
          >
            <Text style={styles.item_txt}>カスタマーサービスに連絡する</Text>
            <View style={styles.item_sub}>
              <FontAwesomeIcon icon={faChevronRight} color={'lightgray'} />
            </View>
          </TouchableOpacity>
        </ScrollView>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1
  },
  item: {
    height: dimen(15),
    backgroundColor: colors.whiteColor,
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    paddingHorizontal: dimen(3),
    borderTopWidth: 0.5,
    borderTopColor: 'lightgray'
  },
  item_img: {
    width: dimen(13),
    height: dimen(13),
    resizeMode: 'cover',
    borderRadius: dimen(6.5)
  },
  item_sub: {
    flexDirection: "row",
    alignItems: "center"
  },
  item_txt: {
    fontSize: dimen(3.5)
  },
  item_sub_txt: {
    paddingRight: dimen(2),
    fontSize: dimen(4),
    color: 'gray'
  },
  border_bebel: {
    elevation: 1,
    shadowColor: 'black',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
  },
});

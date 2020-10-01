import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Image,
  Text,
  ScrollView,
  TouchableOpacity,
  TouchableWithoutFeedback,
  Keyboard,
  Alert
} from 'react-native';

import ImagePicker from 'react-native-image-crop-picker';
import ActionSheet from 'react-native-actionsheet'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faChevronRight } from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ModalEditName from './modalEditName'

import {dimen, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext, SET_AVATAR, SET_NICKNAME } from '../../store/store'
import * as Api from '../../apis/api'

const ICON_USER = require('../../../assets/images/icon_user.png');

export default class ProfileScreen extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      token: context.state.token,
      loading: false,
      showModalEditName: false,
      image: null,
      imgLoadError: false
    };

    this.onClose = this.onClose.bind(this)
    this.onAction = this.onAction.bind(this)
    this.onPickImage = this.onPickImage.bind(this)
  }

  onAction(index) {
    if (index == 0) {
      ImagePicker.openPicker({
        width: 200,
        height: 200,
        cropping: true
      }).then(image => {
        this.onPickImage(image)
      });
    } else if (index == 1) {
      ImagePicker.openCamera({
        width: 200,
        height: 200,
        cropping: true
      }).then(image => {
        this.onPickImage(image)
      });
    }
  }

  onPickImage(image) {
    Alert.alert(
      '写真を更新しますか？',
      '',
      [
        {
          text: 'はい',
          onPress: () => {
            this.setState({image, loading: true})
            this.api_profile(image, 1)
          }
        },
        {
          text: 'いいえ',
          onPress: () => {},
          style: 'cancel'
        },
      ],
      { cancelable: false }
    );
  }

  onClose(value) {
    this.setState({
      showModalEditName: false,
      loading: value != null
    })
  
    if (value) this.api_profile(value)
  }

  async api_profile(value, mode = 0) {
    const {token} = this.state

    await Api.edit_profile_info(token, mode, value)
    if (mode == 1) {
      const user = await Api.get_profile(token)
      this.context.dispatch({type: SET_AVATAR, avatar: user.avatar})
    } else {
      this.context.dispatch({type: SET_NICKNAME, nickname: value})
    }
    this.setState({loading: false})
  }

  render() {
    const {loading, showModalEditName, image, imgLoadError} = this.state
    const {nickname, avatar, address} = this.context.state

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
      <View style={styles.container}>
        <TopBar
          title="個人情報"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {loading && <Indicator/> }

        <ScrollView>
          <TouchableOpacity style={styles.item}
            onPress={() => this.ActionEdit.show() }
          >
            <Text style={styles.item_txt}>プロフィール画像</Text>
            <View style={styles.border_bebel}>
              <Image
                key={avatar}
                style={styles.item_img}
                source={image ? {isStatic: true, uri: image.path} : (imgLoadError ? ICON_USER : {uri: avatar}) }
                onError={() => this.setState({imgLoadError: null})}
              />
            </View>
          </TouchableOpacity>

          <TouchableOpacity style={styles.item}
            onPress={() => this.setState({showModalEditName: true}) }
          >
            <Text style={styles.item_txt}>お名前（フルネーム）</Text>
            <View style={styles.item_sub}>
              <Text style={styles.item_sub_txt}>{nickname}</Text>
              <FontAwesomeIcon icon={faChevronRight} color={'lightgray'} />
            </View>
          </TouchableOpacity>

          <TouchableOpacity style={styles.item}
            onPress={() => this.props.navigation.push('InfoAddressScreen')}>
            <Text style={styles.item_txt}>住所</Text>
            <View style={styles.item_sub}>
              <Text style={styles.item_sub_txt}>{address}</Text>
              <FontAwesomeIcon icon={faChevronRight} color={'lightgray'} />
            </View>
          </TouchableOpacity>
        </ScrollView>

        {showModalEditName && 
          <ModalEditName
            value={nickname}
            onClose={this.onClose} 
          />
        }

        <ActionSheet
          ref={o => this.ActionEdit = o}
          title={''}
          options={['フォトライブラリ', 'カメラ', 'キャンセル']}
          cancelButtonIndex={2}
          destructiveButtonIndex={3}
          onPress={(index) => this.onAction(index) }
        />
      </View>
      </TouchableWithoutFeedback>
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
    fontSize: dimen(3.5),
  },
  item_sub_txt: {
    paddingRight: dimen(2),
    fontSize: dimen(3.5),
  },
  border_bebel: {
    elevation: 1,
    shadowColor: 'black',
    shadowOffset: { width: 2, height: 2 },
    shadowOpacity: 0.4,
    shadowRadius: 1,
  },
});

import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
  Image,
  KeyboardAvoidingView,
  Platform,
  TextInput,
  Switch,
  Alert
} from 'react-native';
import Video from 'react-native-video';
import ImagePicker from 'react-native-image-crop-picker';
import ActionSheet from 'react-native-actionsheet'
import FastImage from 'react-native-fast-image'
import {AirbnbRating} from 'react-native-ratings';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faTimes } from '@fortawesome/free-solid-svg-icons';
import Share from "react-native-share";
import {FlatGrid} from 'react-native-super-grid';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'
import ModalReview from './modalReview'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

const ICON_PHOTO = require('../../../assets/images/add_iamge.png');
const ICON_VIDEO = require('../../../assets/images/icon_tutorial.png');
const ICON_FACEBOOK = require('../../../assets/images/icon_facebook.png');
const ICON_TWITTER = require('../../../assets/images/icon_twitter.png');
const ICON_INSTAGRAM = require('../../../assets/images/icon_instagram.png');
const ICON_LINE = require('../../../assets/images/icon_line.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    const {token, trade_id, isSubsc} = context.state

    this.state = {
      loading: true,
      token: token,
      trade_id: trade_id,
      rating: 0,
      images: [],
      videos: [],
      content: '',
      modalReview: false,

      flagSNS: [false, false, false, false]
    };
  }

  componentDidMount() {
    this.api_evaluation_page()
  }

  onPhotoAction = (index) => {
    if (index == 0) {
      ImagePicker.openPicker({
        width: 200,
        height: 200,
        cropping: true
      }).then(image => {
        this.addImage(image)
      });
    } else if (index == 1) {
      ImagePicker.openCamera({
        width: 200,
        height: 200,
        cropping: true
      }).then(image => {
        this.addImage(image)
      });
    }
  }
  onVideoAction = (index) => {
    if (index == 0) {
      ImagePicker.openPicker({
        mediaType: "video",
      }).then(video => {
        this.addVideo(video)
      });
    } else {
      ImagePicker.openCamera({
        mediaType: "video",
      }).then(video => {
        this.addVideo(video)
      });
    }
  }

  addImage = (image) => {
    const {images} = this.state
    if (images.length < 6) {
      this.setState({images: [...images, image]})
    }
  }

  addVideo = (video) => {
    const {videos} = this.state
    if (videos.length < 3) {
      this.setState({videos: [...videos, video]})
    }
  }

  onEvaluate = () => {
    const {content} = this.state

    if (!content.length) {
      Alert.alert("評価を入力してください")
      return
    }

    this.setState({loading: true})
    this.api_evaluate()
  }

  onClose = (index, kind) => () => {
    if (kind) { // video
      var videos = [...this.state.videos]
      videos = videos.filter((_, i) => i != index )
      this.setState({videos})
    } else {
      var images = [...this.state.images]
      images = images.filter((_, i) => i != index )
      this.setState({images})
    }
  }

  setSNS = (index, val) => {
    const flagSNS = [...this.state.flagSNS]
    flagSNS[index] = val
    this.setState({flagSNS})
  }

  async api_evaluate() {
    const {token, trade_id, rating, images, videos, content, } = this.state
    const response = await Api.evaluate(token, trade_id, rating, content, images, videos)
    
    var img_urls = [], video_urls = []

    if (response.code == 1) {
      response.data.img_urls.map(url => img_urls.push(url))
      response.data.video_urls.map(url => video_urls.push(url))
    }

    this.setState({loading: false})
    setTimeout(() => {
      this.setState({modalReview: true})
      this.share_sns(img_urls, video_urls)
    }, 400)
    
  }

  share_sns = async (img_urls, video_urls) => {
    const {flagSNS, nickname, content} = this.state
    for(var i=0; i<flagSNS.length; i++) {
      if (flagSNS[i] == true) {
        const response = await Share.open({
          title: nickname,
          subject: nickname,
          message: content,
          urls: img_urls.concat(video_urls)
        })
      }
    }
  } 

  async api_evaluation_page() {
    const response = await Api.get_evalution_page(this.state.trade_id)

    this.setState({
      thumb: response.data.thumb,
      nickname: response.data.nickname,
      address: response.data.address,
      loading: false
    })
  }

  render() {
    const {
      loading, thumb, nickname, address, rating, images, videos, content, modalReview,
      flagSNS
    } = this.state;

    const snss = [
      [ICON_FACEBOOK, 'Facebook'],
      [ICON_TWITTER, 'Twitter'],
      [ICON_INSTAGRAM, 'Instagram'],
      [ICON_LINE, 'LINE']
    ]

    return (
      <View style={styles.container}>
        <TopBar
          title="評価"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />

        {modalReview &&
          <ModalReview navigation={this.props.navigation}/>
        }
        {loading ? (
          <Indicator/>
        ):(
          <KeyboardAvoidingView style={{flex: 1}}
            behavior={Platform.OS === 'ios' ? "padding" : ''}
            enabled
          >
          <ScrollView contentContainerStyle={{paddingBottom: dimen(60)}}
            showsVerticalScrollIndicator={false}
          >
            <View style={styles.part1}>
              <FastImage source={{uri: thumb}} style={styles.image_part1} />
              <View style={styles.content_part1}>
                <Text style={styles.text1_content_part1}>{nickname}</Text>
                <Text style={styles.text2_content_part1}>{address}</Text>
              </View>
            </View>
            <View style={styles.part2}>
              <View style={styles.header_part2}>
                <View style={styles.bar} />
                <Text style={styles.text_header_part2}>
                  評価
                </Text>
                <View style={styles.bar} />
              </View>
              <View style={styles.content_part2}>
                <AirbnbRating 
                  count={5} 
                  defaultRating={rating} 
                  size={dimen(8)} 
                  showRating={false} 
                  style={styles.rating} 
                  starContainerStyle={styles.rating_container}
                  onFinishRating={rating => this.setState({rating})}
                />
              </View>
            </View>
            <View style={styles.part3}>
              <TextInput style={styles.text_header_part3}
                value={content}
                onChangeText={text => this.setState({content: text})}
                multiline={true}
                numberOfLines={7}
                placeholder={`レビューを書く`}
              />
              <FlatGrid
                items={images}
                spacing={dimen(4)}
                itemDimension={dimen(28)}
                style={styles.group_img}
                renderItem={({item, index}) => (
                  <ItemImg key={index} uri={item.path} index={index}
                    onClose={this.onClose}
                  />
                )}
              />
              <TouchableOpacity style={styles.add_image}
                onPress={() => this.photoAction.show() }
              >
                <FastImage source={ICON_PHOTO} style={styles.icon_add_image} />
                <Text style={styles.text_add_image}>選択できる画像の上限は６件です</Text>
              </TouchableOpacity>
              <FlatGrid
                items={videos}
                spacing={dimen(4)}
                itemDimension={dimen(28)}
                style={styles.group_img}
                renderItem={({item, index}) => (
                  <ItemVideo key={index} uri={item.path} index={index}
                    onClose={this.onClose}
                  />
                )}
              />
              <TouchableOpacity style={styles.add_image}
                onPress={() => this.videoAction.show() }
              >
                <FastImage source={ICON_VIDEO} style={styles.icon_add_image} />
                <Text style={styles.text_add_image}>選択できる動画の上限は３件です</Text>
              </TouchableOpacity>
            </View>
            
            <View style={styles.snss}>
              {snss.map((sns, i) =>
                <View style={styles.item_sns} key={i}>
                  <View style={styles.sns_sub}>
                    <FastImage source={sns[0]} style={styles.icon_sns} resizeMode='contain' />
                    <Text style={styles.txt_sns}>{sns[1]}</Text>
                  </View>
                  <Switch
                    value={flagSNS[i]}
                    onValueChange={(val) => this.setSNS(i, val)}
                  />
                </View>
              )}
            </View>

            <TouchableOpacity style={styles.button_part4}
              onPress={this.onEvaluate}
            >
              <Text style={styles.text_button}>投稿する</Text>
            </TouchableOpacity>
          </ScrollView>
          </KeyboardAvoidingView>
        )}

        <ActionSheet
          ref={o => this.photoAction = o}
          title={''}
          options={['フォトライブラリ', 'カメラ', 'キャンセル']}
          cancelButtonIndex={2}
          destructiveButtonIndex={3}
          onPress={(index) => this.onPhotoAction(index) }
        />
        <ActionSheet
          ref={o => this.videoAction = o}
          title={''}
          options={['動画ライブラリ', 'カメラ', 'キャンセル']}
          cancelButtonIndex={2}
          destructiveButtonIndex={3}
          onPress={(index) => this.onVideoAction(index) }
        />
      </View>
    );
  }
}

class ItemImg extends PureComponent {
  render() {
    const {uri, index} = this.props
    return (
      <View style={styles.item_review}>
        <Image style={styles.img_item} source={{isStatic: true, uri: uri}} />
        <TouchableOpacity style={styles.close_item}
          onPress={this.props.onClose(index, 0)}
        >
          <FontAwesomeIcon icon={faTimes} size={dimen(4)} color={'#a9a9a9'} />
        </TouchableOpacity>
      </View>
    )
  }
}
class ItemVideo extends PureComponent {
  render() {
    const {uri, index} = this.props
    return (
      <View style={styles.item_review}>
        <Video source={{uri: uri}}
          controls
          paused={true}
          style={styles.video_item}
        />
        <TouchableOpacity style={styles.close_item}
          onPress={this.props.onClose(index, 1)}
        >
          <FontAwesomeIcon icon={faTimes} size={dimen(4)} color={'#a9a9a9'} />
        </TouchableOpacity>
      </View>
    )
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1
  },
  part1: {
    flexDirection: "row",
    backgroundColor: colors.whiteColor,
    paddingVertical: dimen(4),
    paddingHorizontal: dimen(3),
    alignItems: "center"
  },
  image_part1: {
    width: dimen(14.4),
    height: dimen(14.4),
    resizeMode: "cover",
    borderRadius: dimen(2)
  },
  content_part1: {
    flex: 1,
    marginLeft: dimen(3)
  },
  text1_content_part1: {
    flexShrink: 1,
    fontSize: dimen(4),
  },
  text2_content_part1: {
    flexShrink: 1,
    fontSize: dimen(3.5),
    paddingTop: dimen(1)
  },
  part2: {
    backgroundColor: colors.whiteColor,
    marginTop: 1
  },
  header_part2: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "center",
    marginTop: dimen(6)
  },
  text_header_part2: {
    fontSize: dimen(5),
    display: "flex",
    paddingHorizontal: dimen(4),

  },
  bar: {
    height: 1,
    backgroundColor: colors.grayColor,
    width: dimen(10)
  },
  rating: {
    alignItems: "center",
    marginHorizontal: dimen(3),
    paddingHorizontal: dimen(4),
    width: dimen(60),
    borderWidth: 1
  },
  rating_container: {
    marginHorizontal: dimen(3),
    paddingHorizontal: dimen(4),
    width: dimen(80),
    justifyContent: "space-between"
  },
  content_part2: {
    marginTop: dimen(3),
    marginBottom: dimen(6)
  },
  text_header_part3: {
    fontSize: dimen(4),
    color: colors.textColor,
    marginLeft: dimen(4),
    minHeight: dimen(30),
    textAlignVertical: 'top',
    padding: 0,
    paddingVertical: 0
  },
  part3: {
    backgroundColor: colors.whiteColor,
    marginTop: dimen(2),
    paddingVertical: dimen(5)
  },
  add_image: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "center",
    alignSelf: 'center'
  },
  icon_add_image: {
    width: dimen(5.2),
    height: dimen(5.2),
    resizeMode: "contain",
    marginRight: dimen(3)
  },
  text_add_image: {
    color: colors.primaryColor
  },
  text_button: {
    color: colors.whiteColor,
    fontSize: dimen(4.5),
  },
  button_part4: {
    marginTop: dimen(15),
    width: dimen(90),
    alignSelf: 'center',
    backgroundColor: colors.primaryColor,
    borderRadius: dimen(6),
    height: dimen(11),
    alignItems: "center",
    justifyContent: 'center',
  },
  close_item: {
    width: dimen(6),
    height: dimen(6),
    borderRadius: dimen(3),
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: 'white',
    position: 'absolute',
    top: dimen(2),
    right: dimen(2)
  },
  group_img: {
    marginTop: dimen(3),
    alignContent: 'center'
  },
  item_review: {
    position: 'relative',
    width: dimen(28),
    height: dimen(28),
  },
  img_item: {
    width: dimen(28),
    height: dimen(28),
    resizeMode: 'cover'
  },
  video_item: {
    width: dimen(28),
    height: dimen(28),
  },
  icon_sns: {
    width: dimen(5),
    height: dimen(5)
  },
  snss: {
    marginTop: dimen(2)
  },
  item_sns: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: 'white',
    borderBottomColor: 'lightgray',
    borderBottomWidth: 0.2,
    height: dimen(12),
    paddingHorizontal: dimen(4)
  },
  sns_sub: {
    flexDirection: 'row',
    alignItems: 'center'
  },
  txt_sns: {
    fontSize: dimen(4),
    marginLeft: dimen(3.5)
  }
});

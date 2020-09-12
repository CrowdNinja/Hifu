
import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
} from 'react-native';
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faPen, faYenSign, faChevronRight } from '@fortawesome/free-solid-svg-icons';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

const ICON_SUBSC = require('../../../assets/images/icon_badge_subsc.png');
const ICON_DEFAULT = require('../../../assets/images/icon_category1.png');

export default MenuComponent = (props) => {
  const {pack, mode, navigation} = props

  return (
    <TouchableOpacity style={[styles.menu_item, mode == 1 && styles.mode_margin]}
      onPress={() => navigation.navigate("ShopStack", {
        screen: 'ShopMenuScreen',
        params: {
          shop_id: props.shop_id,
          pack_id: pack.id
        }
      })}
    >
      <View style={styles.menu_header}>
        <View style={styles.menu_logo}>
          <CustomFastImage
            url={pack.img}
            style={styles.img_logo}
          />
        </View>

        <View style={{flex: 1}}>
          <Text style={styles.menu_title} numberOfLines={1}>{pack.title}</Text>

          <View style={styles.menu_body}>
            <View style={styles.menu_info}>
              <View style={styles.info_icon}>
                <FontAwesomeIcon icon={faYenSign} size={dimen(2.5)} color='white' />
              </View>
              <Text style={styles.info_text}>{pack.price}円</Text>
            </View>
          </View>
        </View>
      </View>
      
      {pack.subscription_flg == 1 &&
        <FastImage source={ICON_SUBSC} style={styles.img_subsc}/>
      }

      <View style={styles.icon_right}>
        <FontAwesomeIcon icon={faChevronRight} color='lightgray' size={dimen(3.5)} />
      </View>
    </TouchableOpacity>
  )
}

class CustomFastImage extends React.PureComponent {
  constructor(props) {
    super(props)

    this.state = {
      url: props.url,
      style: props.style
    }
  }

  render() {
    const {url, style} = this.state
    return (
      <FastImage
        source={url ? {uri: url} : ICON_DEFAULT}
        style={style}
        onError={() => this.setState({url: null})}
        resizeMode={url ? 'cover' : 'contain'}
      />
    )
  }
}

const styles = StyleSheet.create({
  menu_item: {
    padding: dimen(2),
    borderWidth: 0.3,
    borderColor: colors.gray230,
    position: 'relative'
  },
  mode_margin: {
    marginVertical: dimen(1),
    borderWidth: 0.5,
    borderRadius: 2
  },
  menu_header: {
    flexDirection: "row",
    alignItems: "center"
  },
  img_logo: {
    width: dimen(15),
    height: dimen(15),
    textAlignVertical: "center",
    marginRight: dimen(2),
    borderRadius: 2,
    borderWidth: 0.3,
    borderColor: 'lightgray'
  },
  menu_title: {
    flexShrink: 1,
    fontSize: dimen(3.5),
  },
  info_text: {
    fontSize: dimen(3)
  },
  menu_body: {
    flexDirection: "row",
    alignItems: "center",
    marginTop: 6
  },
  menu_info: {
    flexDirection: "row",
    alignItems: "center",
    marginRight: 8
  },
  info_icon: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: 'center',
    backgroundColor: colors.primaryColor,
    width: dimen(3),
    height: dimen(3),
    marginRight: 4
  },
  text_sale: {
    fontSize: dimen(3),
    color: 'darkgray'
  },
  img_subsc: {
    width: dimen(44),
    height: dimen(11),
    resizeMode: "stretch",
    alignSelf: 'center',
    marginTop: dimen(2)
  },
  icon_right: {
    position: 'absolute',
    right: dimen(1),
    top: 0, bottom: 0,
    alignItems: 'center',
    justifyContent: 'center',
  }
})
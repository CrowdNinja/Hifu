import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
} from 'react-native';
import FastImage from 'react-native-fast-image'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faMapMarkerAlt } from '@fortawesome/free-solid-svg-icons';
import { faClock } from '@fortawesome/free-regular-svg-icons';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

const warn_tip = require('../../../assets/images/warn_tip.png');

export default class App extends PureComponent {
  render() {
    const {reservation, isSubsc} = this.props;

    return (
      <View style={styles.fullStyle}>
        <View style={styles.fullStyle1}>
          <View style={styles.wrapperStyle}>
            <View style={styles.dotted_border}/>
            <View style={styles.part1}>
              <View style={styles.header_part1}>
                <Text style={styles.text_header_part1}>{reservation.nick_name}</Text>
              </View>
              <View style={styles.body_part1}>
                <View style={styles.block1_part1}>
                  <Text style={styles.text1_block1_part1} >{isSubsc ? reservation.items[0].title : reservation.item[0].title}</Text>
                  <Text style={styles.text1_block1_part2}>{isSubsc ? reservation.items[0].knife : reservation.item[0].knife}ショット</Text>
                </View>
                <View style={styles.block2_part1}>
                  <FontAwesomeIcon icon={faMapMarkerAlt} style={styles.icon_block2_part1} />
                  <Text style={styles.text_block2_part1}>
                    {reservation.address}
                  </Text>
                </View>
                <View style={styles.block2_part1}>
                  <FontAwesomeIcon icon={faClock} style={styles.icon_block2_part1} />
                  <Text style={styles.text_block2_part1}>
                    予約時間：{reservation.reservation_time}
                  </Text>
                </View>
              </View>
            </View>
          </View>
          <View style={styles.part2}>
            <FastImage style={styles.image_warning} source={warn_tip} />
            <View style={styles.text_part2}>
              <Text style={styles.text_header_part2}>予約をキャンセルしました。</Text>
            </View>
          </View>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  wrapper: {},
  middleLogo: {
    width: dimen(16),
    height: dimen(16),
    marginTop: dimen(12),
    left: dimen(37)
  },
  fullStyle: {
    textAlign: 'center',
    width: dimen(100),
    textAlign: 'center',
    height: SCREEN_HEIGHT,
    backgroundColor: colors.lightGrayColor,
  },
  part1: {
    paddingHorizontal: dimen(5),
    paddingVertical: dimen(8),
    position: "relative",
    backgroundColor: colors.whiteColor
  },
  block1_part1: {
    flexDirection: "row",
    justifyContent: "space-between"
  },
  block2_part1: {
    flexDirection: "row",
    justifyContent: "flex-start",
    paddingTop: dimen(2)
  },
  text_header_part1: {
    fontSize: dimen(4.5)
  },
  body_part1: {
    paddingVertical: dimen(4),
  },
  dotted_border: {
    position: "absolute",
    width: percent(90),
    marginLeft: percent(5),
    height: percent(100),
    borderWidth: 1,
    borderStyle: "dashed",
    borderRadius: 1,
    top: 1,
    borderColor: colors.textColor,
  },
  text1_block1_part1: {
    fontSize: dimen(4),
    color: colors.blackColor,
    flexShrink: 1
  },
  text1_block1_part2: {
    fontSize: dimen(4),
    color: colors.blackColor,
  },
  iconTextStyle: {
    color: colors.blackColor,
    fontSize: dimen(4.5),
    marginTop: dimen(6),
    textAlign: 'center'
  },
  icon_block2_part1: {
    color: colors.textColor
  },
  btnStyle2: {
    height: dimen(12),
    borderRadius: dimen(6),
    width: dimen(68),
    left: dimen(11),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.primaryColor,
    fontSize: 20,
    marginTop: dimen(20),
  },

  btnStyle1: {
    height: dimen(12),
    borderRadius: dimen(6),
    width: dimen(68),
    left: dimen(11),
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor:  colors.whiteColor,
    borderColor: colors.primaryColor,
    borderWidth: 1,
    fontSize: 20,
    marginTop: dimen(5),
    marginBottom: dimen(13)
  },
  checked: {
    backgroundColor: colors.whiteColor,
    borderWidth: 0,
  },
  checkboxContainerStyle: {
    backgroundColor: 'transparent', 
    marginTop: 0,
    borderWidth: 0,
    paddingTop: 6
  },
  registerTextStyle : {
    color: 'white',
    fontSize: dimen(4)
  },
  registerTextStyle1 : {
    color: colors.primaryColor,
    fontSize: dimen(4)
  },
  wrapperStyle: {
    borderRadius: dimen(2),
  },
  fullStyle1: {
    width: dimen(90),
    left: dimen(5),
    top: dimen(5),
    textAlign: 'center',
    backgroundColor: colors.whiteColor,
    borderRadius: dimen(1.5),
    overflow: 'hidden'
  },
  text_block2_part1: {
    paddingLeft: dimen(2),
    fontSize: dimen(4)
  },
  part2: {
    backgroundColor: colors.whiteColor,
    marginTop: dimen(6),
    alignItems: "center"
  },
  image_warning: {
    width: dimen(17.2),
    height: dimen(17.2),
    marginTop: dimen(4)
  },
  text_header_part2: {
    color: colors.blackColor,
    fontSize: dimen(4.2),
    marginVertical: dimen(5)
  },
  button_header_part2: {
    width: dimen(68),
    height: dimen(10.8),
    borderRadius: dimen(5.4),
    backgroundColor: colors.primaryColor,
    alignItems: "center",
    marginTop: dimen(10.8),
    marginBottom: dimen(6)
  },
  text_button_header_part2: {
    textAlign:"center",
    fontSize: dimen(4),
    lineHeight: dimen(10.8),
    color: colors.whiteColor,
  }
});

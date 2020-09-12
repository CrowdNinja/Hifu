import * as React from 'react';
import {
  StyleSheet,
  View,
  TouchableOpacity,
  Text
} from 'react-native';
import Modal from 'react-native-modal';
import {
  SkypeIndicator
} from 'react-native-indicators';

import colors from '../../config/colors';
import { dimen } from '../../config/dimen';

export default class Indicator extends React.PureComponent {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <Modal
        isVisible={true}
        animationType='fade'
        animationInTiming={10}
        animationOutTiming={10}
        backdropTransitionInTiming={10}
        backdropTransitionOutTiming={10}
      > 
        <View style={styles.container}>
          <Text style={styles.txt_title}>
            お支払い結果をクリック
          </Text>

          <SkypeIndicator
            color={colors.primaryColor}
            style={styles.indicator}
          />

          <View style={styles.btns}>
            <TouchableOpacity style={styles.btn}
              onPress={this.props.onCheck}
            >
              <Text style={styles.txt_btn}>確認する</Text>
            </TouchableOpacity>
            <TouchableOpacity style={[styles.btn, {backgroundColor: colors.redColor}]}
              onPress={this.props.onCancel}
            >
              <Text style={styles.txt_btn}>キャンセル</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    backgroundColor: 'white',
    paddingVertical: dimen(4),
    borderRadius: dimen(3),
    justifyContent: 'center',
    alignItems: 'center'
  },
  indicator: {
    textAlign: "center",
    paddingTop: dimen(15),
    paddingBottom: dimen(8)
  },
  txt_title: {
    textAlign: 'center',
    fontSize: dimen(5)
  },
  btn: {
    paddingHorizontal: dimen(5),
    marginTop: dimen(4),
    height: dimen(10),
    borderRadius: 20,
    backgroundColor: colors.primaryColor,
  },
  txt_btn: {
    color: 'white',
    alignSelf: 'center',
    lineHeight: dimen(10),
    fontSize: dimen(5)
  },
  btns: {
  }
})
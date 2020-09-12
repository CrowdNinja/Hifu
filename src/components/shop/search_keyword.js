import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
  TouchableOpacity,
  ScrollView,
  TouchableWithoutFeedback,
  Keyboard,
  Alert
} from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faTimes } from '@fortawesome/free-solid-svg-icons';
import { faClock } from '@fortawesome/free-regular-svg-icons';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import * as Storage from '../../config/storage'
import * as Api from '../../apis/api'
import { UserContext } from '../../store/store'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);

    this.state = {
      loading: true,
      keywords: []
    };
  }

  async componentDidMount() {
    const keywords = await Storage.getStorage(Storage.KEY_SEARCH)
    this.setState({loading: false, keywords: keywords ?? []})
  }

  onSearch = (keyword) => () =>  {
    if (!keyword.length) {
      Alert.alert("キーワードを入力してください")
    } else {
      const keywords = [...this.state.keywords]
      const sameKeywords = keywords.filter(val => val == keyword )
      if (!sameKeywords.length) {
        keywords.push(keyword)
        Storage.setStorage(keywords, Storage.KEY_SEARCH)
      }

      this.props.navigation.push("SearchResultScreen", {keyword: keyword})
    }
  }

  onReset = (index) => {
    var keywords = []
    if (index > -1) {
      keywords = [...this.state.keywords]
      keywords.splice(index, 1) 
    }
    this.setState({keywords})
    Storage.setStorage(keywords, Storage.KEY_SEARCH)
  }

  render() {
    const {loading, keywords} = this.state;

    return (
      <TouchableWithoutFeedback onPress={() => Keyboard.dismiss()}>
        <View style={styles.container}>
          {loading && <Indicator/> }

          <TopBar
            hasSearch={true}
            backColor={colors.primaryColor}
            navigation={this.props.navigation}
            onSearch={this.onSearch}
          />

          <View style={styles.fullStyle}>
            <ScrollView>
              <View style={styles.part2}>
                <View style={styles.block1_part2}>
                  {keywords.map((keyword, index) => {
                    return (
                      <ItemSearch key={index} title={keyword}
                        index={index}
                        navigation={this.props.navigation}
                        onReset={this.onReset}
                      />
                    )
                  })}
                </View>
              </View>

              <TouchableOpacity style={styles.part3} onPress={() => this.onReset()}>
                <Text style={styles.text_block1_part3}>履歴を削除する</Text>
              </TouchableOpacity>
            </ScrollView>
          </View>
        </View>
      </TouchableWithoutFeedback>
    );
  }
}

const ItemSearch = (props) => {
  const {title, index, navigation} = props

  return (
    <View style={styles.piece1_block1_part2}>
      <TouchableOpacity style={styles.piece1_1_block1_part2}
        onPress={() => navigation.push("SearchResultScreen", {keyword: title})}
      >
        <FontAwesomeIcon icon={faClock} color="lightgray" />
        <Text style={styles.piece1_1_2_block1_part2}>{title}</Text>
      </TouchableOpacity>
      <TouchableOpacity style={{padding: dimen(2)}} onPress={() => props.onReset(index)}>
        <FontAwesomeIcon icon={faTimes} color="gray" />
      </TouchableOpacity>
    </View>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'white'
  },
  part2: {
    paddingHorizontal: dimen(3.5),
    borderBottomColor: colors.grayColor,
    borderBottomWidth: 1
  },
  block1_part2: {
    marginTop: dimen(3)
  },
  piece1_block1_part2: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    borderTopWidth: 1,
    borderTopColor: colors.grayColor
  },
  piece1_1_block1_part2: {
    flex: 1,
    flexDirection: "row",
    alignItems: "center",
    paddingVertical: dimen(4)
  },
  piece1_1_2_block1_part2: {
    fontSize: dimen(4.2),
    marginLeft: dimen(2),
  },
  part3: {
    marginTop: dimen(4),
    flexDirection: 'row',
    justifyContent: 'center'
  },
});

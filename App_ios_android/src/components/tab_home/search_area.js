import React, {PureComponent} from 'react';
import {
  View,
  StyleSheet,
  FlatList,
  Text,
  TouchableOpacity
} from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faCheck} from '@fortawesome/free-solid-svg-icons';

import TopBar from '../common/topbar';

import {dimen} from '../../config/dimen';
import colors from '../../config/colors';
import {PREFECTURES, getProvinceID} from '../../config/constant'
import { UserContext, SET_CITY } from '../../store/store'

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props, context) {
    super(props, context);

    this.state = {
      loading: true,
    };

    this.onSelect = this.onSelect.bind(this)
  }

  onSelect(city) {
    this.context.dispatch({type: SET_CITY, city: city})
    this.props.navigation.pop()
  }

  render() {
    const {city} = this.context.state
    const {navigation} = this.props

    return (
      <View style={styles.container}>
        <TopBar 
          title="店舗検索"
          navigation={navigation}
        />
        <Text style={styles.label}>近くの店舗を探す</Text>
        <TouchableOpacity style={styles.item}
          onPress={() => this.onSelect(null)}
        >
          <Text style={styles.txt_item}>現在地</Text>
          {city == null &&
            <FontAwesomeIcon icon={faCheck} color={colors.primaryColor} />
          }
        </TouchableOpacity>
        <Text style={styles.label}>都道府県から探す</Text>
        <FlatList
          data={PREFECTURES}
          extraData={PREFECTURES}
          initialNumToRender={10}
          renderItem={({item, index}) =>
            <TouchableOpacity key={index} style={styles.item}
              onPress={() => this.onSelect(item[1])}
            >
              <Text style={styles.txt_item}>{item[1]}</Text>
              {city == item[1] &&
                <FontAwesomeIcon icon={faCheck} color={colors.primaryColor} />
              }
            </TouchableOpacity>
          }
          keyExtractor={(_, index) => `${index}`}
          contentInset={{ bottom: 30 }}
        />
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  label: {
    paddingLeft: dimen(3.5),
    paddingBottom: dimen(1),
    paddingTop: dimen(2.5),
    backgroundColor: '#EDEDED',
    color: colors.grayBlack,
    fontSize: dimen(3.5)
  },
  item: {
    height: dimen(12),
    paddingHorizontal: dimen(3.5),
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    borderBottomColor: 'lightgray',
    borderBottomWidth: 0.5,
    backgroundColor: 'white'
  },
  txt_item: {
    color: 'gray',
    fontSize: dimen(3.5)
  }
})

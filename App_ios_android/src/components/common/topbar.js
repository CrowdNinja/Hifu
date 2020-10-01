import React, { PureComponent } from 'react'
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  TextInput,
  SafeAreaView
} from 'react-native'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome'
import { faChevronLeft, faSearch } from '@fortawesome/free-solid-svg-icons'

import {SCREEN_WIDTH, SCREEN_HEIGHT, dimen, percent} from '../../config/dimen';
import colors from '../../config/colors';

export default class Topbar extends PureComponent {
  constructor (props) {
    super(props)

    this.state = {
      searchValue: props.keyword
    }
  }

  onChangeText = (value) => {
    this.setState({searchValue: value})
  }

  goBack = () => this.props.navigation.goBack()

  render() {
    const {title, hasBack, hasSearch, navigation, noBorder,
      onSearch
    } = this.props
    const {searchValue} = this.state

    return (
      <SafeAreaView style={noBorder ? styles.container_noborder : styles.container}>
      <View style={styles.header}>
        {hasBack &&
          <TouchableOpacity style={styles.onClose}
            onPress={this.goBack}
          >
            <FontAwesomeIcon icon={ faChevronLeft } color='white' />
          </TouchableOpacity>
        }
        
        <Text style={styles.title} numberOfLines={1}>{title}</Text>

        {hasSearch && 
          <View style={styles.search_box}>
            <View style={styles.search}>
              <FontAwesomeIcon icon={faSearch} color='lightgray' />
              <TextInput placeholder="キーワードを入力" style={styles.search_textinput} placeholderTextColor='lightgray'
                value={searchValue}
                onChangeText={this.onChangeText}
              />
            </View>
            <TouchableOpacity style={styles.onMessage}
              onPress={onSearch(searchValue)}
            >
              <Text style={styles.text_search}>検索</Text>
            </TouchableOpacity>
          </View>
        }
      </View>
      </SafeAreaView>
    );
  }
}

Topbar.defaultProps = {
  hasBack: true,
  hasSave: true,
  backType: 0,
  saveType: 0,
  saveEnabled: false,
  keyword: '',
  backColor: colors.primaryColor,
  noBorder: false
};

const styles = StyleSheet.create({
  container: {
    backgroundColor: colors.primaryColor,
    elevation: 1,
    shadowColor: colors.primaryColor,
    shadowOffset: { width: 0, height: 1.5 },
    shadowOpacity: 0.3,
    shadowRadius: 1,
    zIndex: 10
  },
  container_noborder: {
    backgroundColor: colors.primaryColor,
    zIndex: 10
  },
  header: {
    height: 48,
    position: 'relative',
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  onClose: {
    height: 48,
    width: 48,
    paddingLeft: 10,
    justifyContent: 'center',
  },
  title: {
    position: 'absolute',
    left: 48, right: 48,
    lineHeight: 48,
    textAlign: 'center',
    fontSize: dimen(4.5),
    color: colors.whiteColor
  },
  search_box: {
    flex: 1,
    flexDirection: "row",
    alignItems: 'center',
    justifyContent: 'space-between'
  },
  search: {
    backgroundColor: colors.whiteColor,
    flex: 1,
    height: dimen(8),
    flexDirection: "row",
    alignItems: "center",
    paddingHorizontal: dimen(2),
    borderRadius: dimen(1),
  },
  search_textinput: {
    flex: 1,
    color: colors.blackColor,
    height: dimen(8),
    padding: 0,
    margin: 0,
    marginLeft: dimen(1),
  },
  saveContainer: {
    paddingHorizontal: dimen(94),
    paddingVertical: 0,
    alignItems: 'center',
    justifyContent: 'center',
    borderRadius: dimen(3),
    height: dimen(6),
    backgroundColor: colors.collonGray,
  },
  saveText: {
    fontSize: dimen(12),
    color: 'white',
    padding: 0,
    margin: 0
  },
  text_search: {
    color: colors.whiteColor,
    fontSize: dimen(4),
    textAlign: 'right'
  },
  onMessage: {
    flexDirection: 'row',
    alignItems: 'center',
    height: 48,
    paddingHorizontal: dimen(3)
  },
})

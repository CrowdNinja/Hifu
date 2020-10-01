import React, { PureComponent } from 'react'
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
} from 'react-native'
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome';
import { faCheck} from '@fortawesome/free-solid-svg-icons';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

export default class App extends PureComponent {
  constructor (props) {
    super(props)
    this.state = {
      menu_data: [[{title: "私のハイフ"},{title: "脱毛機"}], [{title:"価格最低"}, {title:"価格最高"}]],
      modalVisible: false,
      menu_check: [0, -1],
      opened_menu_num: 1,
      orderby: props.orderby
    }
  }

  openModal1 = () => {
    this.setState({opened_menu_num: 0, modalVisible: true})
  }
  openModal2 = () => {
    this.setState({opened_menu_num: 1, modalVisible: true})
  }
  selectMenuItem = (index) => () => {
    const newMenuCheck = [...this.state.menu_check]
    newMenuCheck[this.state.opened_menu_num] = index
    this.setState({
      menu_check: newMenuCheck,
      modalVisible: false
    }, () => {
      this.props.onSearchOrder(index + 2)
    })
  }

  renderModal = () => {
    const {modalVisible, menu_data, menu_check, opened_menu_num
    } = this.state

    return (
      modalVisible && 
        <View style={styles.content_popup}>
          <View style={styles.part_popup}>
            {menu_data[opened_menu_num].map((item, index) => {
              return (
                <TouchableOpacity key={index} style={styles.field_wrapper_popup} onPress={this.selectMenuItem(index)}>
                  <View style={styles.field_popup}>
                    <Text style={[styles.text_field_popup, index == menu_check[opened_menu_num]? styles.check: '']}>{item.title}</Text>
                    {index == menu_check[opened_menu_num] && 
                      <FontAwesomeIcon icon={faCheck} style={styles.check} />
                    }
                  </View>
                </TouchableOpacity>
              )
            })}
          </View>
        </View>
    )
  }
  renderSortBar = () => {
    const {orderby} = this.props
    return (
      <>
      {/*<TouchableOpacity
        style={styles.menu_item_button}
        onPress={() => {this.openModal1()}}
        >
        <Text style={[styles.sortbar_text, opened_menu_num==0 && modalVisible ? styles.check : '']}>私のハイフ</Text>
        <FontAwesomeIcon
          icon={!opened_menu_num && modalVisible ? faCaretUp : faCaretDown}
          size={dimen(5)}
        style={[styles.icon_carpet, !opened_menu_num ? styles.check : styles.uncheck]}/>
      </TouchableOpacity>*/}

      <TouchableOpacity onPress={() => this.props.onSearchOrder(1)}>
        <Text style={orderby == 1 ? styles.txt_selected : {}}>注目店舗</Text>
      </TouchableOpacity>

      <TouchableOpacity
        style={styles.menu_item_button}
        onPress={this.openModal2}>
        <Text style={orderby > 1 ? styles.txt_selected : {}}>
          {orderby == 3 ? '価格最高' : (orderby == 2 ? '価格最低' : '価格順')}
        </Text>
        {/*<FontAwesomeIcon
          icon={faFilter}
          size={dimen(3.5)}
          style={[styles.filter_icon, opened_menu_num == 1 ? styles.check : styles.uncheck]}/>*/}
      </TouchableOpacity>
      </>
    )
  }

  render() {
    const {} = this.props
    
    return (
      <>
      <View style={styles.sortbar}>
        {this.renderSortBar()}
      </View>
      <View>
        {this.renderModal()}
      </View>
      </>
    );
  }
}

App.defaultProps = {
  hasBack: true,
  hasSave: true,
  backType: 0,
  saveType: 0,
  saveEnabled: false
};

const styles = StyleSheet.create({
  sortbar: {
    height: dimen(12),
    paddingHorizontal: dimen(3),
    alignItems: 'center',
    color: 'white',
    zIndex: 8, 
    flexDirection: "row",
    justifyContent: "space-between",
    backgroundColor: colors.whiteColor,
    elevation: 1,
    shadowColor: 'black',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 1,
  },
  content_popup: {
    backgroundColor:'transparent',
  },
  popup_wrapper: {
    backgroundColor: colors.whiteColor
  },
  field_wrapper_popup: {
    width: percent(100),
    backgroundColor: colors.whiteColor, 
    height: dimen(12)
  },
  field_popup: {
    paddingHorizontal: dimen(4),
    borderBottomWidth: 1,
    borderBottomColor: colors.grayColor,
    borderTopColor: colors.grayColor,
    borderTopWidth: 1,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between"
  },
  part_popup: {
    backgroundColor: colors.modalBackColor,
  },
  text_field_popup:{
    fontSize: dimen(4),
    lineHeight: dimen(12)
  },
  title_dropdown: {
    width: dimen(30)
  },
  option_text_dropdown: {
    borderWidth: 1
  },
  home:{
    textAlign: "center",
    alignItems: "center"
  },
  check: {
    color: colors.primaryColor,
  },
  uncheck: {
  },
  menu_item_button: {
    flexDirection: "row",
    alignItems: "center"
  },
  icon_carpet: {
    marginBottom: 4,
    color: 'lightgray'
  },
  filter_icon: {
    marginLeft: dimen(1),
    color: 'lightgray'
  },
  txt_selected: {
    color: colors.primaryColor
  }
})

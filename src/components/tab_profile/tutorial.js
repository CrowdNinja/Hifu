import React, {PureComponent} from 'react';
import {
  StyleSheet,
  View,
  Text,
} from 'react-native';
import Video from 'react-native-video';

import TopBar from '../common/topbar';
import Indicator from '../common/indicator'

import {ERR_DURATION, ERR_MSG} from '../../config/constant'
import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';
import { UserContext } from '../../store/store'
import * as Api from '../../apis/api'
import { ScrollView } from 'react-native-gesture-handler';

const ICON_ABOUT = require('../../../assets/images/icon_category1.png');

export default class App extends PureComponent {
  static contextType = UserContext

  constructor(props) {
    super(props);
    this.state = {
      loading: true,
      tutorials: []
    };
  }

  componentDidMount() {
    this.api_()
  }

  async api_() {
    const tutorials = await Api.tutorials()

    this.setState({loading: false, tutorials})
  }

  render() {
    const {
      loading, tutorials
    } = this.state;

    return (
      <View style={styles.container}>
        <TopBar
          title="機器の使用方法"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />          

        {loading && <Indicator/> }
        {!loading &&
          <ScrollView style={styles.content}>
            {tutorials.map((tutorial, index) =>
              <View key={index} style={styles.card}>
                <Video source={{uri: tutorial.url}}
                  controls
                  paused={true}
                  style={styles.video}
                />
                <Text style={styles.txt}>{tutorial.filename.split('.')[0]}</Text>
              </View>
            )}
            
          </ScrollView>
        }
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  content: {
    flex: 1,
    padding: dimen(3)
  },
  card: {
    backgroundColor: 'white',
    padding: dimen(3),
    elevation: 1,
    shadowColor: 'black',
    shadowOffset: { width: 1, height: 1 },
    shadowOpacity: 0.3,
    shadowRadius: 1,
    borderRadius: dimen(1),
    marginBottom: dimen(3)
  },
  video: {
    width: '100%',
    height: undefined,
    aspectRatio: 2/1,
  },
  txt: {
    fontSize: dimen(3.5),
    fontWeight: 'bold',
    marginTop: dimen(2.5)
  }
});
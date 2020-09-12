import * as React from 'react';
import {
  View,
  ActivityIndicator, 
  StyleSheet
} from 'react-native';
import Modal from 'react-native-modal';


export default class App extends React.PureComponent {
  render() {
    return (
      <Modal
        visible={true}
        animationType='none'
        animationInTiming={10}
        animationOutTiming={10}
        backdropTransitionInTiming={10}
        backdropTransitionOutTiming={10}
      >
        <View style={styles.container}>
          <View style={styles.content}>
            <ActivityIndicator size="large" color="white" />
          </View>
        </View>
      </Modal>
    );
  }
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  content: {
    width: 120,
    height: 120,
    borderRadius: 20,
    backgroundColor: '#33333377',
    alignItems: 'center',
    justifyContent: 'center',
  }
});

import React, {PureComponent} from 'react';
import {
  StyleSheet,
} from 'react-native';
import { WebView } from 'react-native-webview';

import TopBar from '../common/topbar';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

export default class ProfileShopScreen extends PureComponent {
  render() {
    const {content} = this.props.route.params;
    return (
      <>
        <TopBar
          title="店舗紹介"
          backColor={colors.primaryColor}
          navigation={this.props.navigation}
        />
        <WebView source={{
          html: `<head>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          </head>
          <body>${content}</body>
          </html>`
        }} />
      </>
    );
  }
}

const styles = StyleSheet.create({
});


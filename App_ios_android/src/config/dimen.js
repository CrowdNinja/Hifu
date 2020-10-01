import {Dimensions} from 'react-native'

export const SCREEN_WIDTH = Dimensions.get('window').width;
export const SCREEN_HEIGHT = Dimensions.get('window').height;

export const dimen = (value) => {
  return SCREEN_WIDTH / 100 * value
}

export const percent = (value) => {
  return value + '%'
}
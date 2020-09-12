import AsyncStorage from '@react-native-community/async-storage';

export const KEY_INITIAL = '@INITIAL'
export const KEY_SEARCH = '@SEARCH'

export const setStorage = async (value, key = '@TOKEN') => {
  try {
    const jsonValue = JSON.stringify(value)
    await AsyncStorage.setItem(key, jsonValue)
  } catch (e) {
    console.log("Storage Set", e)
  }
}

export const getStorage = async (key = '@TOKEN') => {
  try {
    const jsonValue = await AsyncStorage.getItem(key)
    return jsonValue != null ? JSON.parse(jsonValue) : null;
  } catch(e) {
    console.log("Storage Set", e)
  }
}
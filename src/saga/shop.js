import { takeLatest, put, call } from 'redux-saga/effects';
import * as Api from '../apis/api'

import {
  FETCH_SHOP,
  FETCH_SHOP_SUCCESS,
  FETCH_SHOP_FAIL,
  FETCH_SHOP_CITY,
  FETCH_SHOP_CITY_SUCCESS,
  FETCH_SHOP_CITY_FAIL,
} from '../config/constant'

function* getShops(action) {
  try {
    const {latitude, longitude} = action
    const shops = yield Api.get_shops(latitude, longitude)

    yield put({ 
      type: FETCH_SHOP_SUCCESS,
      shops: shops
    });
  } catch (error) {
    yield put({ type: FETCH_SHOP_FAIL })
  }
}
export function* watchShops() {
  yield takeLatest(FETCH_SHOP, getShops);
}

function* searchShops(action) {
  try {
    const {latitude, longitude, city} = action
    const shops = yield Api.search_shop(latitude, longitude, city)
    yield put({ 
      type: FETCH_SHOP_CITY_SUCCESS,
      searchShops: shops
    });
  } catch (error) {
    yield put({ type: FETCH_SHOP_CITY_FAIL })
  }
}
export function* watchSearchShops() {
  yield takeLatest(FETCH_SHOP_CITY, searchShops);
}

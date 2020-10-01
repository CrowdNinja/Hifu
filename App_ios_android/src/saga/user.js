import { takeLatest, put, call } from 'redux-saga/effects';
import * as Api from '../apis/api'

import {
  FETCH_BOOKMARK,
  FETCH_BOOKMARK_SUCCESS,
  FETCH_BOOKMARK_FAIL
} from '../config/constant'

function* getBookmarks(action) {
  try {
    const {token, shop_ids, shop_id, flag} = action
    var bookmarks = []

    if (shop_ids) {
      if (flag) {
        Api.set_like(token, shop_id)
        bookmarks = [...shop_ids, shop_id]
      }
      else {
        Api.cancel_like(token, shop_id)
        bookmarks = shop_ids.filter(id => id != shop_id)
      }
    } else {
      bookmarks = yield Api.favorite_shop_ids(token)
    }

    yield put({ 
      type: FETCH_BOOKMARK_SUCCESS,
      bookmarks: bookmarks
    });
  } catch (error) {
    yield put({ type: FETCH_BOOKMARK_FAIL })
  }
}

export function* watchBookmark() {
  yield takeLatest(FETCH_BOOKMARK, getBookmarks);
}
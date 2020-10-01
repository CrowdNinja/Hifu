import { all, fork } from 'redux-saga/effects';

import {
  watchShops,
  watchSearchShops
} from './shop';
import {watchBookmark} from './user';

export default function* rootSaga () {
  yield all([
    fork(watchShops),
    fork(watchSearchShops),
    fork(watchBookmark),
  ]);
};

import {
  FETCH_BOOKMARK,
  FETCH_BOOKMARK_SUCCESS,
  FETCH_BOOKMARK_FAIL
} from '../config/constant'

const initialState = {
  bookmarks: [],
  fetchingBookmark: false,
  errorBookmark: false
}

export default function dataReducer (state = initialState, action) {
  switch (action.type) {
    case FETCH_BOOKMARK:
      return {
        ...state,
        bookmarks: [],
        fetchingBookmark: true
      }
    case FETCH_BOOKMARK_SUCCESS:
      return {
        ...state,
        bookmarks: action.bookmarks,
        fetchingBookmark: false,
      }
    case FETCH_BOOKMARK_FAIL:
      return {
        ...state,
        fetchingBookmark: false,
        errorBookmark: true
      }
    default:
      return state
  }
}

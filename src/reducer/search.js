import {
  FETCH_SHOP_CITY,
  FETCH_SHOP_CITY_SUCCESS,
  FETCH_SHOP_CITY_FAIL
} from '../config/constant'

const initialState = {
  searchShops: [],
  fetchingShop: false,
  errorShop: false
}

export default function dataReducer (state = initialState, action) {
  switch (action.type) {
    case FETCH_SHOP_CITY:
      return {
        ...state,
        searchShops: [],
        fetchingShop: true
      }
    case FETCH_SHOP_CITY_SUCCESS:
      return {
        ...state,
        searchShops: action.searchShops,
        fetchingShop: false,
      }
    case FETCH_SHOP_CITY_FAIL:
      return {
        ...state,
        fetchingShop: false,
        errorShop: true
      }
    default:
      return state
  }
}

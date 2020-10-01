import {
  FETCH_SHOP,
  FETCH_SHOP_SUCCESS,
  FETCH_SHOP_FAIL
} from '../config/constant'

const initialState = {
  shops: [],
  fetchingShop: false,
  errorShop: false
}

export default function dataReducer (state = initialState, action) {
  switch (action.type) {
    case FETCH_SHOP:
      return {
        ...state,
        shops: [],
        fetchingShop: true
      }
    case FETCH_SHOP_SUCCESS:
      return {
        ...state,
        shops: action.shops,
        fetchingShop: false,
      }
    case FETCH_SHOP_FAIL:
      return {
        ...state,
        fetchingShop: false,
        errorShop: true
      }
    default:
      return state
  }
}

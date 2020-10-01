import {
  FETCH_SHOP,
  FETCH_SHOP_CITY,
  FETCH_BOOKMARK
} from '../config/constant'

export function fetchShop(latitude, longitude) {
  return {
    type: FETCH_SHOP,
    latitude: latitude,
    longitude: longitude
  }
}

export function fetchSearchShop(latitude, longitude, city) {
  return {
    type: FETCH_SHOP_CITY,
    latitude: latitude,
    longitude: longitude,
    city: city
  }
}

export function fetchBookmark(token, shop_ids = null, shop_id = null, flag = null) {
  return {
    type: FETCH_BOOKMARK,
    token: token,
    shop_ids: shop_ids,
    shop_id: shop_id,
    flag: flag
  }
}

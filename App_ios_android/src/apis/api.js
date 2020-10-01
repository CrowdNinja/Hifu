import User from '../models/user'
import Shop from '../models/shop'
import Pack, {PackDetail, PackItem, PackInfo} from '../models/pack'
import Item from '../models/item'
import Address from '../models/address'
import Coupon from '../models/coupon'
import Trade from '../models/trade'
import Notification from '../models/notification'
import Price from '../models/price'
import Agreement from '../models/agreement'

export const BASE_URL = 'https://beauty-admin.com/user_api/'
// export const BASE_URL = 'http://192.168.8.104:8080/user_api/'
export const URL_ADDRESS_API = 'https://www.land.mlit.go.jp/webland/api/CitySearch'

export const axios = require('axios');

export const sign_in = async (account, password) => {
  const formData = new FormData();
  formData.append('account', account);
  formData.append('password', password);

  try {
    const response = await axios.post(BASE_URL + `login`, formData)

    return response.data.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const sign_up = async (name, password, phone, code) => {
  const formData = new FormData();
  formData.append('account', phone);
  formData.append('password', password);
  formData.append('sms', code);
  formData.append('nickname', name);
  
  try {
    const response = await axios.post(BASE_URL + `register`, formData)
    return response.data.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_sms = async (phone, area_code) => {
  const formData = new FormData();
  formData.append('account', phone);
  formData.append('area_code', area_code);

  try {
    const response = await axios.post(BASE_URL + `sms`, formData)

    return response.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_profile = async (token) => {
  const formData = new FormData();  
  formData.append('token', token);

  try {
    const response = await axios.post(BASE_URL + `profile`, formData)
    const data = response.data.data

    return data.account ? new User(data) : new User()
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_shops = async (lat, lng, city = null) => {
  const formData = new FormData();
  formData.append('lat', lat);
  formData.append('lng', lng);
  if (city) formData.append('city', city);

  try {
    const response = await axios.post(BASE_URL + `user_home`, formData)
    const data = response.data.data

    return data.list.map(d => new Shop(d))
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_shop_detail = async(id, token, page = 1) => {
  const formData = new FormData();
  formData.append('shop_id', id);
  if (token) formData.append('token', token);
  formData.append('page', page);
  formData.append('pagesize', 20)

  try {
    const response = await axios.post(BASE_URL + `shop_details`, formData)
    const data = response.data.data

    return [new Shop(data.shop, data.pack, data.list.list, data.total_count, data.praise_ratio), data.is_favorite]
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_shop_introduce = async(id) => {
  const formData = new FormData();
  formData.append('shop_id', id);

  try {
    const response = await axios.post(BASE_URL + `get_shop_introduce`, formData)
    const data = response.data.data

  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_pack_detail = async(shop_id, pack_id) => {
  const formData = new FormData();
  formData.append('shop_id', shop_id);
  formData.append('pack_id', pack_id);

  try {
    const response = await axios.post(BASE_URL + `pack_details`, formData)
    const data = response.data.data
    
    const packDetail = new PackDetail(data.pack)
    const packItems = data.pack_item.map((d) => new PackItem(d))
    const shop = new Shop(data.shop)
    
    return [shop, packDetail, packItems]
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_hot_keyword = async (token) => {
  const formData = new FormData();
  formData.append('token', token);

  try {
    const response = await axios.post(BASE_URL + `hot_keyword`, formData)
    const data = response.data.data

  } catch (error) {
    console.log("ERROR", error)
  }
}

export const search_shop = async (lat, lng, city, keywords = null, kind = null, orderby = null, page = 1, pagesize = 20) => {
  const formData = new FormData();
  formData.append('lat', lat);
  formData.append('lng', lng);
  formData.append('city', city);
  if (keywords) formData.append('keywords', keywords);
  if (kind) formData.append('type', kind);
  if (orderby) formData.append('orderby', orderby);
  formData.append('page', page);
  formData.append('pagesize', pagesize);

  try {
    const response = await axios.post(BASE_URL + `search_shop`, formData)
    const data = response.data.data
    const shops = data.list.map(d => new Shop(d))

    return shops
  } catch (error) {
    return []
  }
}

// NEWS
export const get_news = async (token, page = 1, pagesize = 20) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('page', page);
  formData.append('pagesize', pagesize);

  try {
    const response = await axios.post(BASE_URL + `message`, formData)
    const data = response.data.data

    return data.list.map(d => new Notification(d))
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_news_detail = async (token, id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('message_id', id);

  try {
    const response = await axios.post(BASE_URL + `message_info`, formData)
    const data = response.data.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const about = async () => {
  try {
    const response = await axios.post(BASE_URL + `about`)
    const data = response.data.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const tutorials = async () => {
  try {
    const response = await axios.post(BASE_URL + `tutorials`)
    const data = response.data.data

    return data.list
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_agreement = async () => {
  try {
    const response = await axios.post(BASE_URL + `get_agreements`)
    const data = response.data.data

    return data.agreements.map(d => new Agreement(d))
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_img = async () => {
  try {
    const response = await axios.post(BASE_URL + `get_img`)
    const data = response.data.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

// ADDRESS
export const get_cities = async (id) => {
  try {
    const response = await axios.get(URL_ADDRESS_API, {
      params: {
        area: id
      }
    })
    const data = response.data.data

    return data.map(d => [d.id, d.name])
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_user_address = async (token, page = 1, pagesize = 20) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('page', page);
  formData.append('pagesize', pagesize);

  try {
    const response = await axios.post(BASE_URL + `user_address_list`, formData)
    const data = response.data.data

    return data.list.map(d => new Address(d))
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_address = async (token, id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('address_id', id);

  try {
    const response = await axios.post(BASE_URL + `edit_address`, formData)
    const data = response.data.data

  } catch (error) {
    console.log("ERROR", error)
  }
}

export const delete_address = async (token, id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('address_id', id);

  try {
    const response = await axios.post(BASE_URL + `del_address`, formData)
    const data = response.data.data

  } catch (error) {
    console.log("ERROR", error)
  }
}

export const set_default_address = async (token, id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('address_id', id);

  try {
    const response = await axios.post(BASE_URL + `set_default_address`, formData)
    const data = response.data.data

  } catch (error) {
    console.log("ERROR", error)
  }
}

export const edit_address = async (token, id, name, phone, province, city, area, address) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('address_id', id);
  formData.append('name', name);
  formData.append('phone', phone);
  formData.append('province', province);
  formData.append('city', city);
  formData.append('area', area);
  formData.append('address', address);

  try {
    const response = await axios.post(BASE_URL + `edit_address`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const add_address = async (token, name, phone, province, city, area, address) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('name', name);
  formData.append('phone', phone);
  formData.append('province', province);
  formData.append('city', city);
  formData.append('area', area);
  formData.append('address', address);

  try {
    const response = await axios.post(BASE_URL + `add_address`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

// PROFILE EDIT
export const edit_profile_info = async (token, mode, value) => {
  const formData = new FormData()
  formData.append('token', token)
  if(mode == 0) formData.append('nickname', value)
  if(mode == 1) {
    formData.append('avatar', {
      uri: value.path,
      name: value.filename,
      type: value.mime
    })
  }

  try {
    const response = await axios.post(BASE_URL + `edit`, formData)
    const data = response.data

  } catch (error) {
    console.log("ERROR", error)
  }
}

export const edit_password = async (token, password, newPassword, confirmPassword) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('auth_password', password);
  formData.append('password', newPassword);
  formData.append('password1', confirmPassword);

  try {
    const response = await axios.post(BASE_URL + `edit`, formData)
    return response.data.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const edit_phone = async (token, account, sms) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('account', account);
  formData.append('sms', sms);

  try {
    const response = await axios.post(BASE_URL + `edit`, formData)

    return response.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

// Coupon
export const get_user_coupon = async (token, shop_id = null, page = 1, pagesize = 50) => {
  const formData = new FormData();
  formData.append('token', token);
  if (shop_id) formData.append('shop_id', shop_id);
  formData.append('page', page);
  formData.append('pagesize', pagesize);

  try {
    const response = await axios.post(BASE_URL + `user_coupon`, formData)
    const data = response.data.data

    return data.list.map(d => new Coupon(d))
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const scan_give_coupon = async (token, id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('id', id);

  try {
    const response = await axios.post(BASE_URL + `scan_give_coupon`, formData)
    const data = response.data

    return data.code
  } catch (error) {
    console.log("ERROR", error)
  }
}

//PAY *** profile charge
export const get_recharge = async () => {
  try {
    const response = await axios.post(BASE_URL + `get_recharge`)
    const data = response.data.data

    return data.map(d => new Price(d))
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const charge = async (token, pay_type, extra, money, nonce) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('pay_type', pay_type);
  if (extra) formData.append('extra', extra);
  if (money) formData.append('money', money);
  if (nonce) formData.append('source_id', nonce);

  try {
    const response = await axios.post(BASE_URL + `recharge`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

// Trade & Pay
export const get_pay_info = async (token, shop_id, pack_id, coupon_id = null) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('shop_id', shop_id);
  formData.append('pack_id', pack_id);
  if (coupon_id) formData.append('coupon_id', coupon_id);

  try {
    const response = await axios.post(BASE_URL + `pay_info_page`, formData)
    const data = response.data.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_trade_status = async (trade_id) => {
  const formData = new FormData();
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `get_trade_status`, formData)

    return response.data.code
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const del_trade = async (token, trade_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `del_trade`, formData)

    return response.data.code
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const pay_order = async (token, shop_id, pack_id, pay_type, source_id = null, pay_password = null, coupon_id = null) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('shop_id', shop_id);
  formData.append('pack_id', pack_id);
  formData.append('pay_type', pay_type);
  if (source_id) formData.append('source_id', source_id);
  if (pay_password) formData.append('pay_password', pay_password);
  if (coupon_id) formData.append('coupon_id', coupon_id);

  try {
    const response = await axios.post(BASE_URL + `pay_order`, formData)
    const data = response.data

    return JSON.parse(JSON.stringify(data))
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const pay_trade = async (token, trade_id, pack_id, pay_type, pay_password, coupon_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);
  formData.append('pack_id', pack_id);
  formData.append('pay_type', pay_type);
  if (pay_password) formData.append('pay_password', pay_password);
  if (coupon_id) formData.append('coupon_id', coupon_id);

  try {
    const response = await axios.post(BASE_URL + `pay_trade`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_trade_list = async (token, status, page = 1, pagesize = 50) => {
  const formData = new FormData();
  formData.append('token', token);
  if (status != -5) formData.append('status', status);
  formData.append('page', page);
  formData.append('pagesize', pagesize);

  try {
    const response = await axios.post(BASE_URL + `trade_list`, formData)
    const data = response.data.data

    return data.list.map( d => new Trade(d) )
  } catch (error) {
    console.log("ERROR", error)
  }
}

// Reservation
export const get_reserve_item = async (token, trade_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `get_reservation_item`, formData)
    const data = response.data.data

    return [data.list.map(d => new Item(d)), data.is_subsc, data.hours, data.paytime]
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const reservation_order = async (token, trade_id, item_ids, time, phone, remark) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);
  formData.append('item_ids', item_ids);
  formData.append('time', time);
  formData.append('phone', phone);
  formData.append('remark', remark);

  try {
    const response = await axios.post(BASE_URL + `reservation`, formData)
    const data = response.data


    return data.code
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const reservation_order_subsc = async (token, trade_id, items, phone, remark) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);
  formData.append('items', JSON.stringify(items))
  formData.append('phone', phone);
  formData.append('remark', remark);

  try {
    const response = await axios.post(BASE_URL + `reservation_subsc`, formData)
    const data = response.data

    return data.code
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_forbid_reservation_time = async (token, trade_id, item_id) => {
  const formData = new FormData();
  formData.append('trade_id', trade_id);
  formData.append('item_id', item_id);

  try {
    const response = await axios.post(BASE_URL + `get_forbid_reservation_time`, formData)
    const data = response.data
    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_reservation_basic_info = async (trade_id, item_id) => {
  const formData = new FormData()
  formData.append('trade_id', trade_id)
  formData.append('item_id', item_id)

  try {
    const response = await axios.post(BASE_URL + `get_reservation_basic_info`, formData)

    return response.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const check_reservation_time = async (trade_id, time, item_id) => {
  const formData = new FormData();
  formData.append('trade_id', trade_id);
  formData.append('time', time);
  formData.append('item_id', item_id);

  try {
    const response = await axios.post(BASE_URL + `check_reservation_time`, formData)
    const data = response.data.data

    return data.data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const use_reservation_page = async (token, trade_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `use_reservation_page`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const use_reservation_subsc_page = async (token, trade_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `use_reservation_subsc_page`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const polling = async (polling_id) => {
  const formData = new FormData();
  formData.append('polling_id', polling_id);

  try {
    const response = await axios.post(BASE_URL + `polling`, formData)
    const data = response.data

  } catch (error) {
    console.log("ERROR", error)
  }
}

export const cancel_reservation = async (token, trade_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `cancel_reservation`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const cancel_reservation_page = async (token, trade_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `cancel_reservation_page`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const cancel_reservation_subsc = async (token, trade_id, reservation_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);
  formData.append('reservation_id', reservation_id);

  try {
    const response = await axios.post(BASE_URL + `cancel_reservation_subsc`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const get_evalution_page = async (trade_id) => {
  const formData = new FormData();
  formData.append('trade_id', trade_id);

  try {
    const response = await axios.post(BASE_URL + `evaluate_page`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const evaluate = async (token, trade_id, score, content, imgs, videos) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('trade_id', trade_id);
  formData.append('score', score);
  formData.append('content', content);
  imgs.map(img => formData.append('img[]', {
    uri: img.path,
    name: img.filename,
    type: img.mime
  }))
  videos.map(video => formData.append('video[]', {
    uri: video.path,
    name: video.filename,
    type: video.mime
  }))

  try {
    const response = await axios.post(BASE_URL + `evaluate`, formData)
    const data = response.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}


// Pay Password
export const check_pay_password = async (token, password) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('password', password);

  try {
    const response = await axios.post(BASE_URL + `check_pay_pass`, formData)
    const data = response.data

    return data.code
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const edit_pay_pass = async (token, password) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('password', password);

  try {
    const response = await axios.post(BASE_URL + `edit_pay_pass`, formData)
    const data = response.data

    return data.code
  } catch (error) {
    console.log("ERROR", error)
  }
}

// LIKE
export const set_like = async (token, shop_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('shop_id', shop_id);

  try {
    const response = await axios.post(BASE_URL + `favorite`, formData)
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const cancel_like = async (token, shop_id) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('shop_id', shop_id);

  try {
    const response = await axios.post(BASE_URL + `remove_favorite`, formData)
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const favorite_shop_ids = async (token) => {
  const formData = new FormData();
  formData.append('token', token);

  try {
    const response = await axios.post(BASE_URL + `favorite_shop_ids`, formData)
    const data = response.data.data

    return data
  } catch (error) {
    console.log("ERROR", error)
  }
}

export const favorite_shops = async (token, lat, lng) => {
  const formData = new FormData();
  formData.append('token', token);
  formData.append('lat', lat);
  formData.append('lng', lng);

  try {
    const response = await axios.post(BASE_URL + `favorite_shops`, formData)
    const data = response.data.data

    return data.list ? data.list.map(d => new Shop(d)) : []
  } catch (error) {
    console.log("ERROR", error)
  }
}


// 店舗側
export const admin_login = async (username, password) => {
  const formData = new FormData();
  formData.append('username', username);
  formData.append('password', password);

  try {
    const response = await axios.post(BASE_URL + `shop_login`, formData)
  } catch (error) {
    console.log("ERROR", error)
  }
}


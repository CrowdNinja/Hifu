import React, {createContext, useReducer} from 'react';

import User from '../models/user'
import * as CONST from '../config/env'

const UserContext = createContext(initialState);
const { Provider } = UserContext;

const initialState = {
  token: null,
  account: null,
  nickname: '',
  avatar: null,
  money: 0,
  address: '',
  pay_password1: '',
  square_customer_id: null,

  password: '',
  pay_type: 0,
  coupon: {money: 0},
  times: [],
  trade_id: null,
  latitude: CONST.DEFAULT_POSITION.lat,
  longitude: CONST.DEFAULT_POSITION.lng,

  bookmark_ids: [],
  city: null
};

export const GET_TOKEN = "GET_TOKEN"
export const SET_PROFILE = "SET_PROFILE"
export const SET_MY_MONEY = "SET_MY_MONEY"
export const SET_AVATAR = "SET_AVATAR"
export const SET_NICKNAME = "SET_NICKNAME"
export const SET_PHONE = "SET_PHONE"  
export const SET_PAY_PASSWORD = "SET_PAY_PASSWORD"
export const SET_SQUARE_ID = "SET_SQUARE_ID"
export const SET_TIMES = "SET_TIMES"
export const SET_COUPON = "SET_COUPON"

export const SET_TRADE = "SET_TRADE"
export const SET_PAY_TYPE = "SET_PAY_TYPE"
export const SET_SUBSC = "SET_SUBSC"
export const SET_BOOKMARK = "SET_BOOKMARK"

export const SET_LOCATION = "SET_LOCATION"
export const SET_CITY = 'SET_CITY'

const StateProvider = ( { children } ) => {
  const [state, dispatch] = useReducer((state, action) => {
    switch(action.type) {      
      case SET_PROFILE:
        return { ...state,
          nickname: action.nickname,
          token: action.token,
          account: action.account,
          avatar: action.avatar,
          money: action.money,
          address: action.address,
          pay_password1: action.pay_password1,
          square_customer_id: action.square_customer_id
        }
      case SET_MY_MONEY:
        return { ...state,
          money: parseInt(action.money)
        }
      case SET_AVATAR:
        return { ...state,
          avatar: action.avatar
        }
      case SET_NICKNAME:
        return { ...state,
          nickname: action.nickname
        }
      case SET_PHONE:
        return { ...state,
          account: action.account
        }
      case SET_PAY_PASSWORD:
        return { ...state,
          pay_password1: action.pay_password1
        }
      case SET_SQUARE_ID:
        return { ...state,
          square_customer_id: action.square_customer_id
        }
      case SET_TIMES:
        return { ...state,
          times: action.times
        }
      case SET_COUPON:
        return { ...state,
          coupon: action.coupon
        }
      case SET_PAY_TYPE:
        return { ...state,
          pay_type: action.pay_type
        }
      case SET_TRADE:
        return { ...state,
          trade_id: action.trade_id
        }
      case SET_BOOKMARK:
        return { ...state,
          bookmark_ids: action.bookmark_ids
        }
      case SET_LOCATION:
        return {
          ...state,
          latitude: action.latitude,
          longitude: action.longitude,
        }
      case SET_CITY:
        return {
          ...state,
          city: action.city
        }
      default:
        return state
    };
  }, initialState);

  return <Provider value={{ state, dispatch }}>{children}</Provider>
};

export { UserContext, StateProvider }

import { combineReducers } from 'redux'
import shopReducer from './shop'
import searchReducer from './search'
import userReducer from './user'

const rootReducer = combineReducers({
  userReducer,
  searchReducer,
  shopReducer,
})

export default rootReducer

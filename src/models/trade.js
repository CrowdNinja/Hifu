import {PackInfo} from './pack'

export default class Trade {
  constructor(data = {}) {
    this.adminid = data.adminid
    this.ctime = data.ctime
    this.end_time = data.end_time
    this.id = data.id
    this.item = data.item
    this.money = data.money
    this.pack_id = data.pack_id
    this.pack_img = data.pack_img
    this.pack_num = data.pack_num
    this.pack_title = data.pack_title
    this.pay_money = data.pay_money
    this.reservation_id = data.reservation_id
    this.shop_nickname = data.shop_nickname
    this.status = data.status
    this.status_name = data.status_name
    this.thumb = data.thumb
    this.pack_info = new PackInfo(data.pack_info)

    this.subscription_flg = data.subscription_flg
    this.subscription_type = data.subscription_type
  }
}
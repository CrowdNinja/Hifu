export default class Pack {
  constructor(data = {}) {
    this.id = data.id
    this.title = data.title
    this.price = data.price
    this.knife = data.knife
    this.sell_num = data.sell_num
    this.num = data.num
    this.subscription_flg = data.subscription_flg
    this.subscription_type = data.subscription_type
    this.count = data.count
    this.discount = data.discount
    this.img = data.img
  }
};

export class PackDetail {
  constructor(data = {}) {
    this.title = data.title
    this.price = data.price
    this.efficacy = data.efficacy
    this.img = data.img
    this.number = data.number
    this.pack_id = data.pack_id
    this.position = data.position
    this.reservation_info = data.reservation_info
    this.service_process = data.service_process
    this.validity_time = data.validity_time
    this.subscription_flg = data.subscription_flg
    this.subscription_type = data.subscription_type
    this.count = data.count
    this.discount = data.discount
  }
}

export class PackItem {
  constructor(data = {}) {
    this.knife = data.knife
    this.num = data.num
    this.text = data.text
    this.title = data.title
    this.subscription_flg = data.subscription_flg
    this.subscription_type = data.subscription_type
  }
}

export class PackInfo {
  constructor(data = {}) {
    this.id = data.id
    this.title = data.title
    this.price = data.price
    this.adminid = data.adminid
    this.aid = data.aid
    this.img = data.img
    this.remark = data.remark
    this.validity_time = data.validity_time
    this.reservation_info = data.reservation_info
    this.number = data.number
    this.efficacy = data.efficacy
    this.position = data.position
    this.service_process = data.service_process
    this.ctime = data.ctime
    this.subscription_flg = data.subscription_flg
    this.subscription_type = data.subscription_type
  }
}















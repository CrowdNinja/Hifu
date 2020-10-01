export default class Coupon {
  constructor(data = {}) {
    this.adminid = data.adminid
    this.desc = data.desc
    this.end_time = data.end_time
    this.id = data.id
    this.limit_money = data.limit_money
    this.money = data.money
    this.order_id = data.order_id
    this.shop_name = data.shop_name
    this.status = data.status
    this.status_name = data.status_name
    this.usetime = data.usetime
    this.title = data.title
  }
};

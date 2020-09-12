import Pack from './pack'
import Review from './review'

export default class Shop {
  constructor(data = {}, packs = [], reviews = [], total_count = null, praise_ratio = null) {
    this.shop_id = data.shop_id
    this.thumb = data.thumb
    this.nickname = data.nickname
    this.keywords = data.keywords
    this.score = data.score
    this.lat = data.lat
    this.lng = data.lng
    this.address = data.address
    this.distance = data.d

    if (packs.length) {
      this.packs = packs.map(d => new Pack(d))
    } else {
      this.packs = data.pack ? data.pack.map(d => new Pack(d)) : []
    }

    this.reviews = reviews.length ? reviews.map(d => new Review(d)) : []

    this.hours = data.hours
    this.phone = data.phone
    this.text = data.text
    this.total_count = total_count
    this.praise_ratio = praise_ratio

    this.desc_title = data.desc_title
    this.desc = data.desc
    this.access = data.access
    this.regular_holiday = data.regular_holiday
    this.facility = data.facility
    this.parking_lot = data.parking_lot
    this.commitment = data.commitment
    this.remarks = data.remarks
    this.other = data.other
  }
};
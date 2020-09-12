export default class Item { // Reservation Item
  constructor(data = {}) {
    this.id = data.id
    this.item_name = data.item_name
    this.knife = data.knife
    this.pack_item_id = data.pack_item_id
    this.time = data.time

    this.reserve_time = null
  }
};
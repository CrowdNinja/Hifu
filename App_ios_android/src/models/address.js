export default class Address {
  constructor(data = {}) {
    this.address = data.address
    this.area = data.area
    this.city = data.city
    this.id = data.id
    this.is_default = data.is_default
    this.name = data.name
    this.phone = data.phone
    this.province = data.province
  }
};

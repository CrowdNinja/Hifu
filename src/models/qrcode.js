export default class QRCode {
  constructor(data = {}) {
    this.qr = data.qr
    this.status = data.status
    this.title = data.title
    this.type = data.type
  }
};
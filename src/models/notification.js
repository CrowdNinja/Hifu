export default class Notification {
  constructor(data = {}) {
    this.content = data.content
    this.ctime = data.ctime
    this.img = data.img
    this.id = data.id
    this.is_read = data.is_read
    this.message_id = data.message_id
    this.title = data.title
    this.user_id = data.user_id
  }
};

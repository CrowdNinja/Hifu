export default class Review {
  constructor(data = {}) {
    this.id = data.id
    this.user_id = data.user_id
    this.avatar = data.avatar
    this.nickname = data.nickname

    this.content = data.content
    this.ctime = data.ctime
    this.score = data.score

    this.imgs = data.imgs
  }
};

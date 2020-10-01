export default class Agreement {
  constructor(data = {}) {
    this.content = data.content
    this.title = data.title
    this.checked = false
  }
};

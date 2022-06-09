export class User {
  constructor(token, id, login, name, email, createdAt, updatedAt) {
    this.token = token
    this.id = Number(id)
    this.login = String(login)
    this.name = String(name)
    this.email = String(email)
    this.createdAt = Date.parse(createdAt)
    this.updatedAt = Date.parse(updatedAt)
  }
}

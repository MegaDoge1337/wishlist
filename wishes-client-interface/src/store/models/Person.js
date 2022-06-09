export class Person {
  constructor(id, name, email, createdAt) {
    this.id = Number(id)
    this.name = String(name)
    this.email = String(email)
    this.createdAt = Date.parse(createdAt)
  }
}

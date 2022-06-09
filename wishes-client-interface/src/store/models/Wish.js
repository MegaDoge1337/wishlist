export class Wish {
  constructor(id, user_id, title, description, percentageOfImplementation, isArchived, createdAt, updatedAt) {
    this.id = Number(id)
    this.title = String(title)
    this.description = String(description)
    this.percentageOfImplementation = Number(percentageOfImplementation)
    this.isArchived = isArchived === 1
    this.createdAt = createdAt
    this.updatedAt = updatedAt
  }
}

import {Wish} from "src/store/models/Wish";

export function store (state, payload) {
  // TODO: Переделать на загрузку в модель
  state.wishes = payload.map(wish => {
      return new Wish(
        wish.id,
        wish.user_id,
        wish.title,
        wish.description,
        wish.percentage_of_implementation,
        new Date(wish.created_at),
        new Date(wish.updated_at)
      )
  })
}

// export function edit (state, payload) {
//   let index = state.wishes.findIndex(wish => wish.id === payload.wish.id)
//   state.wishes[index] = payload.wish
// }

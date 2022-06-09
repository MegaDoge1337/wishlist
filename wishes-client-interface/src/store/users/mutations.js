import {User} from "src/store/models/User";
import {LocalStorage} from "quasar";

export function store(state, payload) {
  let user = new User(
    payload.token,
    payload.user.id,
    payload.user.login,
    payload.user.name,
    payload.user.email,
    payload.user.createdAt,
    payload.user.updatedAt
  )

  let userData = JSON.stringify(user)
  LocalStorage.set('user:data', userData)

  state.user = user
}

export function destroy(state) {
  LocalStorage.clear()
  state.user = null
}

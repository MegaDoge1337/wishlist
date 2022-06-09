import {LocalStorage} from "quasar";
import {User} from "../models/User";

export default function () {
  let userData = LocalStorage.getItem('user:data')

  if(userData !== null) {
    userData = JSON.parse(userData)
    let user = new User(
      userData.token,
      userData.id,
      userData.login,
      userData.name,
      userData.email,
      userData.createdAt,
      userData.updatedAt
    )

    return {
      user: user
    }
  }

  return {
    user: null
  }
}

import axios from "axios";
import {Credentials} from "src/store/models/Credentials";
import {Register} from "src/store/models/Register";

export async function login (context, payload) {
  let apiUrl = process.env.API_URL
  let credentials = new Credentials(payload.login, payload.password)

  let isFailed = false

  await axios.post(apiUrl + 'auth/login', credentials, {
    headers: {
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      isFailed = false
      context.commit('store', response.data)
    })
    .catch(error => {
      isFailed = true
      console.log(error)
    })

  return isFailed
}

export async function logout (context, payload) {
  let apiUrl = process.env.API_URL
  let accessToken = payload.token

  let isFailed = false

  await axios.post(apiUrl + 'auth/logout', {}, {
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${accessToken}`
    }
  })
    .then(response => {
      isFailed = false
      context.commit('destroy')
    })
    .catch(error => {
      isFailed = true
      console.log(error)
    })

  return isFailed
}

export async function register(context, payload) {
  let apiUrl = process.env.API_URL
  let registrationData = new Register(payload.login, payload.name, payload.email, payload.password)

  let isFailed = false

  await axios.post(apiUrl + 'auth/register', registrationData, {
    headers: {
      'Content-Type': 'application/json',
    }
  })
    .then(response => {
      isFailed = false
      context.commit('store', response.data)
    })
    .catch(error => {
      isFailed = true
      console.log(error)
    })

  return isFailed
}

import axios from "axios";

export async function getSelfWishes (context, payload) {

  let apiUrl = process.env.API_URL
  let accessToken = payload.token

  let isFailed = false

  await axios.get(apiUrl + 'wishes/storage/self', {
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${accessToken}`
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

export async function archiveWish (context, payload) {

  let apiUrl = process.env.API_URL
  let accessToken = payload.token
  let wishId = payload.id

  let isFailed = false

  await axios.delete(apiUrl + `wishes/actions/archive/${wishId}`, {
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${accessToken}`
    }
  })
    .then(response => {
      isFailed = false
    })
    .catch(error => {
      isFailed = true
      console.log(error)
    })

  return isFailed
}

export async function editWish (context, payload) {
  let apiUrl = process.env.API_URL
  let accessToken = payload.token
  let wishId = payload.id

  let isFailed = false

  await axios.put(apiUrl + `wishes/actions/edit/${wishId}`,{
      title: payload.title,
      description: payload.description,
      percentage_of_implementation: payload.percentageOfImplementation
    },
    {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${accessToken}`
      }
    })
    .then(response => {
      isFailed = false
    })
    .catch(error => {
      isFailed = true
      console.log(error)
    })

  return isFailed
}

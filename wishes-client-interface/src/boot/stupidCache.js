import { boot } from 'quasar/wrappers'
import {LocalStorage} from "quasar";

const stupidCache = {

  enabled: process.env.STUPID_CACHE_ENABLE === 'true',
  prefix: process.env.STUPID_CACHE_DATA_PREFIX,
  catalog: [],

  init() {
    this.getCatalog()
    if(this.catalog === null) {
      this.catalog = []
    }
  },

  getData(key) {
    if(this.enabled) {
      return JSON.parse(LocalStorage.getItem(`${this.prefix}:${key}`))
    } else {
      throw new Error("Stupid caching disabled")
    }
  },
  saveData(data, key) {
    console.log(data)
    if(this.enabled) {
      LocalStorage.set(`${this.prefix}:${key}`, JSON.stringify(data))
      if(!this.catalog.includes(key)) {
        this.catalog.push(key)
      }
      this.saveCatalog()
    } else {
      throw new Error("Stupid caching disabled")
    }
  },
  destroyData(key) {
    if(this.enabled) {
      LocalStorage.remove(`${this.prefix}:${key}`)
    } else {
      throw new Error("Stupid caching disabled")
    }
  },

  isCached(key) {
    return this.catalog.includes(key)
  },

  saveCatalog() {
    if(this.enabled) {
      LocalStorage.set(`${this.prefix}:catalog`, JSON.stringify(this.catalog))
    } else {
      throw new Error("Stupid caching disabled")
    }
  },

  getCatalog() {
    if(this.enabled) {
      this.catalog = JSON.parse(LocalStorage.getItem(`${this.prefix}:catalog`))
    } else {
      throw new Error("Stupid caching disabled")
    }
  },

  dropAllData() {
    this.catalog.forEach(key => {
      console.log(key)
      this.destroyData(key)
    })
    this.destroyData('catalog')
    this.catalog = []
  }
}

export default boot(({ app }) => {
  app.config.globalProperties.$stupidCache = stupidCache
})

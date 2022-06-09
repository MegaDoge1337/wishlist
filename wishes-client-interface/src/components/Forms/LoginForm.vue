<template>
  <div class="q-pa-md" style="max-width: 400px">
    <Loader :loading="loading" message="Подождите, проверяются учётные данные"/>
    <q-card class="my-card text-white">
      <q-card-section>
        <div class="text-h6 text-center">Авторизация</div>
      </q-card-section>

      <q-card-section class="q-pt-none">
        <div class="q-gutter-md">
          <q-input
            filled
            v-model="login"
            label="Логин"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Введите логин']"
          />

          <q-input
            filled
            type="password"
            v-model="password"
            label="Пароль"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Введите пароль']"
          />

          <div>
            <q-btn label="Войти" color="primary" class="q-mr-md" @click="doLogin"/>
            <q-btn flat label="Не помню пароль" color="primary"/>
          </div>
        </div>
      </q-card-section>
    </q-card>


  </div>
</template>

<script>
import { defineComponent } from 'vue'
import {Notify} from "quasar";
import Loader from "components/Common/Loader";

export default defineComponent({
  name: 'LoginForm',
  components: { Loader },
  props: {},
  data() {
    return {
      login: '',
      password: '',
      loading: false
    }
  },
  methods: {
    doLogin() {
      this.loading = !this.loading
      let login = this.login
      let password = this.password

      if (login.length === 0 || password.length === 0) {
        Notify.create({
          type: 'negative',
          message: `Ошибка авторизации: обязательные поля не заполнены`
        })
        this.loading = false
      }

      let payload = { login, password }
      this.$store.dispatch('users/login', payload)
        .then(isFailed => {
          this.loading = false
          if(!isFailed) {
            location.reload()
          } else {
            Notify.create({
              type: 'negative',
              message: `Ошибка авторизации: внутрення ошибка сервера`
            })
          }
        })
        .catch(error => {
          Notify.create({
            type: 'negative',
            message: `Ошибка авторизации: внутрення ошибка приложения`
          })
          this.loading = false
        })
    }
  },
  mounted() {
    console.log(this.$store.getters['users/getUser'])
  }
})
</script>

<style>
.q-btn__content {
  font-weight: 600;
}
</style>

<template>
  <div class="q-pa-md" style="width: 400px">
    <Loader :loading="loading" message="Подождите, регистриурется новая учётная запись"/>
    <q-card class="my-card text-white">
      <q-card-section>
        <div class="text-h6 text-center">Регистрация</div>
      </q-card-section>

      <q-card-section class="q-pt-none">
        <div class="q-gutter-md">
          <q-input
            filled
            v-model="name"
            label="Имя"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Введите ваше имя']"
          >
            <template v-slot:after>
              <q-btn flat round icon="badge" />

              <q-tooltip
                :delay="1000"
                anchor="center right"
                self="center left"
                :offset="[35, 10]"
                transition-show="flip-right"
                transition-hide="flip-left"
              >
                Имя, под которым вас будут видеть другие пользователи
              </q-tooltip>
            </template>
          </q-input>

          <q-input
            filled
            v-model="email"
            type="email"
            label="Электронная почта"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Введите вашу электронную почту']"
          >
            <template v-slot:after>
              <q-btn flat round icon="alternate_email"/>

              <q-tooltip
                :delay="1000"
                anchor="center right"
                self="center left"
                :offset="[35, 10]"
                transition-show="flip-right"
                transition-hide="flip-left"
              >
                Ваша электронная почта, на которую будут поступать уведомления
              </q-tooltip>
            </template>
          </q-input>

          <q-input
            filled
            v-model="login"
            label="Логин"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Введите логин']"
          >
            <template v-slot:after>
              <q-btn flat round icon="person"/>

              <q-tooltip
                :delay="1000"
                anchor="center right"
                self="center left"
                :offset="[35, 10]"
                transition-show="flip-right"
                transition-hide="flip-left"
              >
                Ваша электронная почта, на которую будут поступать уведомления
              </q-tooltip>
            </template>
          </q-input>

          <q-input
            filled
            v-model="password"
            :type="passwordVisibility ? 'text' : 'password'"
            label="Пароль"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Введите пароль']"
          >
            <template v-slot:after>

              <q-btn flat round :icon="passwordVisibility ? 'visibility_off' : 'visibility'" @click="passwordVisibility = !passwordVisibility"/>

            </template>
          </q-input>

          <q-input
            filled
            v-model="repeatedPassword"
            :type="repeatedPasswordVisibility ? 'text' : 'password'"
            label="Повтор пароля"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Повторите пароль']"
          >

            <template v-slot:after>

              <q-btn flat round :icon="repeatedPasswordVisibility ? 'visibility_off' : 'visibility'" @click="repeatedPasswordVisibility = !repeatedPasswordVisibility"/>

            </template>
          </q-input>

          <div class="flex flex-center">
            <q-btn label="Зарегистрироваться" color="primary" class="q-mr-md" @click="doRegister"/>
          </div>
        </div>
      </q-card-section>
    </q-card>


  </div>
</template>

<script>
import { defineComponent } from 'vue'
import Loader from "components/Common/Loader";
import {Notify} from "quasar";

export default defineComponent({
  name: 'RegisterForm',
  components: { Loader },
  data() {
    return {
      name: '',
      email: '',
      login: '',
      password: '',
      repeatedPassword: '',
      passwordVisibility: false,
      repeatedPasswordVisibility: false,
      loading: false,
      user: null
    }
  },
  methods: {
    doRegister() {
      this.loading = true

      let name = this.name
      let email = this.email
      let login = this.login
      let password = this.password
      let repeatedPassword = this.repeatedPassword

      if(name.length === 0 ||
        email.length === 0 ||
        login.length === 0 ||
        password.length === 0 ||
        repeatedPassword === 0)
      {
        Notify.create({
          type: 'negative',
          message: `Ошибка регистрации: форма заполнена не полностью`
        })
        this.loading = false
        return
      }

      if(password !== repeatedPassword) {
        Notify.create({
          type: 'negative',
          message: `Ошибка регистрации: пароли не совпадают`
        })
        this.loading = false
        return
      }

      this.$store.dispatch('users/register', { name, email, login, password })
        .then(isFailed => {
          this.loading = false
          if(!isFailed) {
            location.reload()
          } else {
            Notify.create({
              type: 'negative',
              message: `Ошибка регистрации: внутренняя ошибка сервера`
            })
          }
        })
        .catch(error => {
          console.log(error)
        })
    }
  },
  mounted() {
    this.user = this.$store.getters['users/getUser']

    if(this.user !== null) {
      this.$router.push('/')
    }
  },
  props: {}
})
</script>


<style>
.q-btn__content {
  font-weight: 600;
}
</style>

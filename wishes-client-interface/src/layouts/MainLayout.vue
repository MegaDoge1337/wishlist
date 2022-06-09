<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          Меню
        </q-toolbar-title>

        <div style="font-size: 20px;">
          Wishes App (alpha 0.1 v <q-icon name="bug_report"></q-icon>)
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      behavior="mobile"
    >
      <q-list>
        <q-item-label
          header
        >
          Меню
        </q-item-label>

        <MenuLinks
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />

        <q-separator v-if="user !== null"/>

        <!--Кнопки действий-->

<!--        <q-item-->
<!--          v-if="user !== null"-->
<!--          clickable-->
<!--          @click="clearCache"-->
<!--        >-->
<!--          <q-item-section avatar>-->
<!--            <q-icon name="delete" />-->
<!--          </q-item-section>-->

<!--          <q-item-section>-->
<!--            <q-item-label>Очистить кеш</q-item-label>-->
<!--          </q-item-section>-->

<!--          <q-tooltip-->
<!--            :delay="1000"-->
<!--            anchor="center right"-->
<!--            self="center left"-->
<!--            :offset="[10, 10]"-->
<!--            transition-show="flip-right"-->
<!--            transition-hide="flip-left"-->
<!--          >-->
<!--            Очистить хранилище с предзагруженными данными-->
<!--          </q-tooltip>-->
<!--        </q-item>-->

        <q-item
          v-if="user !== null"
          clickable
          @click="doLogout"
        >
          <q-item-section avatar>
            <q-icon name="logout" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Выйти</q-item-label>
          </q-item-section>

          <q-tooltip
            :delay="1000"
            anchor="center right"
            self="center left"
            :offset="[10, 10]"
            transition-show="flip-right"
            transition-hide="flip-left"
          >
            Выйти из учётной записи
          </q-tooltip>
        </q-item>

        <q-banner v-if="user === null" class="q-pt-md q-pb-md bg-negative text-white">
          Чтобы получить полный доступ, войдите в вашу учётную запись или зарегистрируйте новую
        </q-banner>

        <q-item
          clickable
          tag="a"
          href="/#/auth"
          v-if="user === null"
        >
          <q-item-section avatar>
            <q-icon name="login" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Войти</q-item-label>
          </q-item-section>

          <q-tooltip
            :delay="1000"
            anchor="center right"
            self="center left"
            :offset="[10, 10]"
            transition-show="flip-right"
            transition-hide="flip-left"
          >
            Войти в вашу учётную запись
          </q-tooltip>
        </q-item>

        <q-item
          clickable
          tag="a"
          href="/#/auth/register"
          v-if="user === null"
        >
          <q-item-section avatar>
            <q-icon name="how_to_reg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Зарегистрироваться</q-item-label>
          </q-item-section>

          <q-tooltip
            :delay="1000"
            anchor="center right"
            self="center left"
            :offset="[10, 10]"
            transition-show="flip-right"
            transition-hide="flip-left"
          >
            Зарегистрировать новую учётную запись
          </q-tooltip>
        </q-item>

      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import MenuLinks from 'components/Common/MenuLinks.vue'

const linksList = [
  {
    title: 'Список пользователей',
    caption: 'Все зарегистрированные пользователи',
    icon: 'people',
    link: '#'
  },
  {
    title: 'Мои желания',
    caption: 'Ваши сокровенные мечты',
    icon: 'star',
    link: '/#/wishes/self'
  },
  {
    title: 'Мой архив',
    caption: 'Ваш личный архив желаний',
    icon: 'archive',
    link: '#'
  },
  {
    title: 'Мой аккаунт',
    caption: 'Настройки вашей учётной записи',
    icon: 'settings',
    link: '#'
  }
];

import { defineComponent, ref } from 'vue'
import {Notify} from "quasar";

export default defineComponent({
  name: 'MainLayout',
  components: {
    MenuLinks
  },
  data() {
    return {
      leftDrawerOpen: false,
      essentialLinks: [],
      user: null,
      notification: false
    }
  },
  methods: {
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    },
    doLogout() {
      this.$store.dispatch('users/logout', this.user)
      .then(isFailed => {
        if(!isFailed) {
          location.reload()
        } else {
          Notify.create({
            type: 'negative',
            message: `Ошибка выхода: внутренняя ошибка сервера`
          })
        }
      })
      .catch(error => console.log(error))
    },
    clearCache() {
      this.$stupidCache.dropAllData()
      location.reload()
    }
  },
  mounted() {
    this.$stupidCache.init()
    this.user = this.$store.getters['users/getUser']

    if(this.user !== null) {
      this.essentialLinks = linksList
    }
  }
})
</script>

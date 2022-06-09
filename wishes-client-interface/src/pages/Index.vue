<template>
  <q-page class="flex flex-center column">
    <h1 class="text-h1">Wish List</h1>
    <h3 class="text-h3">Агрегатор желаний</h3>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue';
import {Notify} from "quasar";

export default defineComponent({
  name: 'IndexPage',
  mounted() {
    // Notify.create({
    //   type: 'primary',
    //   message: `Добро пожаловать на альфа-тест приложения!`,
    //   position: 'top',
    //   icon: 'pan_tool'
    // })
  }
})
</script>

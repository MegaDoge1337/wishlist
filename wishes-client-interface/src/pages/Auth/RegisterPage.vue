<template>
  <q-page class="flex flex-center column">
    <RegisterForm/>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue';
import RegisterForm from "components/Forms/RegisterForm";

export default defineComponent({
  name: 'RegisterPage',
  components: { RegisterForm },
  mounted() {}
})
</script>

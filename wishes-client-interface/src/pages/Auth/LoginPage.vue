<template>
  <q-page class="flex flex-center column">
    <LoginForm/>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue';
import LoginForm from "components/Forms/LoginForm";

export default defineComponent({
  name: 'LoginPage',
  components: { LoginForm },
  data() {
    return {
      user: null
    }
  },
  mounted() {
    this.user = this.$store.getters['users/getUser']

    if(this.user !== null) {
      this.$router.push('/')
    }
  }
})
</script>

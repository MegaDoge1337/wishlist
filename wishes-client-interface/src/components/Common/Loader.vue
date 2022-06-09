<template>
  <div class="flex flex-center column q-mb-lg" v-show="loading">
    <div class="lds-dual-ring q-mb-md"></div>
    {{ message }}
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'Loader',
  props: {
    message: {
      type: String,
      required: true
    },
    loading: {
      type: Boolean,
      required: true
    }
  }
})
</script>

<style>

.lds-dual-ring {
  display: inline-block;
  width: 80px;
  height: 80px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid var(--q-primary);
  border-color: var(--q-primary) transparent var(--q-primary) transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>

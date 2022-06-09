<template>
  <q-item
    clickable
    tag="a"
    :href="link"
  >
    <q-item-section
      v-if="icon"
      avatar
    >
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ title }}</q-item-label>
    </q-item-section>

    <q-tooltip
      :delay="1000"
      anchor="center right"
      self="center left"
      :offset="[10, 10]"
      transition-show="flip-right"
      transition-hide="flip-left"
    >
      {{ caption }}
    </q-tooltip>
  </q-item>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'MenuLinks',
  props: {
    title: {
      type: String,
      required: true
    },

    caption: {
      type: String,
      default: ''
    },

    link: {
      type: String,
      default: '#'
    },

    icon: {
      type: String,
      default: ''
    }
  }
})
</script>

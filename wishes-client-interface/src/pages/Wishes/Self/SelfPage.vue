<template>
  <q-page class="">
    <div class="q-pa-md">
      <q-table
        title="Ваши желания"
        :rows="rows"
        :columns="columns"
        row-key="id"
        binary-state-sort
        :pagination="{ rowsPerPage: 0 }"
        :pagination-label="(firstRowIndex, endRowIndex, totalRowsNumber) => `${firstRowIndex}-${endRowIndex} из ${totalRowsNumber}`"
        rows-per-page-label="Показать желаний:"
        :loading="loading"
        color="primary"

        @row-click="onRowClick"
      >

        <template v-slot:top-right>
            <q-btn flat rounded label="Добавить желание" color="primary" icon="add" @click="onAddButtonClick"/>
        </template>

        <template v-slot:body-cell-percentageOfImplementation="props">
          <q-td :class="buildProgressClass(props.row.percentageOfImplementation)">
            <q-linear-progress :value="props.row.percentageOfImplementation" class="q-mt-md" />
          </q-td>
        </template>

      </q-table>

      <!--Диалог создания желания-->
      <q-dialog v-model="isCreateDialogOpened">
        <q-card class="q-dialog-plugin">
          <q-card-section class="flex justify-between">
            <div class="text-h6">Добавить желание</div>
            <q-btn flat round color="negative" icon="close" @click="isCreateDialogOpened= !isCreateDialogOpened"/>
          </q-card-section>
          <q-card-section>
            <q-input
              filled
              v-model="createDialogData.title"
              label="Название"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Поле не может быть пустым']"
            />
            <q-input
              filled
              v-model="createDialogData.description"
              label="Подробности"
              type="textarea"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Поле не может быть пустым']"
            />

            <div class="flex column">
              <h1 class="text-h6">Процесс реализации</h1>
              <q-radio v-model="createDialogData.percentageOfImplementation" :val="0.0" label="Не сбылось" />
              <q-radio v-model="createDialogData.percentageOfImplementation" :val="0.5" label="На половину сбылось" />
              <q-radio v-model="createDialogData.percentageOfImplementation" :val="1.0" label="Сбылось" />
            </div>
            <q-linear-progress :value="createDialogData.percentageOfImplementation" class="q-mt-md" />
          </q-card-section>
          <q-card-actions align="center">
            <q-btn flat round color="positive" icon="check" @click="onAddNewWishAccept"/>
          </q-card-actions>
        </q-card>
      </q-dialog>

      <!--Диалог изменения желания-->
      <q-dialog v-model="isEditDialogOpened">
        <q-card class="q-dialog-plugin">
<!--          <q-card-section v-show="processedEdit" class="flex justify-center">-->
<!--            <Loader :loading="processedEdit" message="Редактируем желание, подождите"/>-->
<!--          </q-card-section>-->
          <q-card-section class="flex justify-between">
            <div class="text-h6">Обновить желание</div>
            <q-btn flat round color="negative" icon="close" @click="onEditDialogClosed"/>
          </q-card-section>
          <q-card-section>
            <q-input
              filled
              v-model="editedWishData.title"
              label="Название"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Поле не может быть пустым']"
            />
            <q-input
              filled
              v-model="editedWishData.description"
              label="Подробности"
              type="textarea"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Поле не может быть пустым']"
            />
            <div class="flex column">
              <h1 class="text-h6">Процесс реализации</h1>
              <q-radio v-model="editedWishData.percentageOfImplementation" :val="0.0" label="Не сбылось" />
              <q-radio v-model="editedWishData.percentageOfImplementation" :val="0.5" label="На половину сбылось" />
              <q-radio v-model="editedWishData.percentageOfImplementation" :val="1.0" label="Сбылось" />
            </div>
            <q-linear-progress :value="editedWishData.percentageOfImplementation" class="q-mt-md" />
          </q-card-section>
          <q-card-actions align="center">
            <q-btn flat round color="positive" icon="check" @click="onEditDialogAccept"/>
            <q-btn flat round color="primary" icon="archive" @click="onArchived"/>
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>
  </q-page>
</template>

<script>
import {Loading, Notify} from "quasar";

const columns = [
  {
    name: 'title',
    required: true,
    label: 'Название',
    align: 'left',
    field: 'title',
    sortable: true,
    style: row => (row.percentageOfImplementation === 1.0 ? 'background: var(--q-positive)' : '')
  },
  {
    name: 'description',
    align: 'center',
    label: 'Подробности',
    field: 'description',
    sortable: true,
    style: row => (row.percentageOfImplementation === 1.0 ? 'background: var(--q-positive)' : '')
  },
  {
    name: 'percentageOfImplementation',
    align: 'center',
    label: 'Процесс реализации',
    field: 'percentageOfImplementation',
    sortable: true,
    style: row => (row.percentageOfImplementation === 1.0 ? 'background: var(--q-positive)' : '')
  },
]

import { defineComponent } from 'vue';
import Loader from "components/Common/Loader";

export default defineComponent({
  name: 'SelfPage',
  data() {
    return {
      rows: [],
      columns: columns,
      isCreateDialogOpened: false,
      isEditDialogOpened: false,
      editedWishData: {
        id: 0,
        title: '',
        description: '',
        percentageOfImplementation: 0.0
      },
      createDialogData: {
        title: '',
        description: '',
        percentageOfImplementation: 0.0
      },
      loading: false,
      user: null,
      processedEdit: true,
    }
  },
  mounted() {
    // this.$stupidCache.init()
    this.loading = true

    this.user = this.$store.getters['users/getUser']
    if(this.user === null) {
      this.$router.push('/')
    }

    // if(this.$stupidCache.isCached('self-wishes')) {
    //   this.rows = this.$stupidCache.getData('self-wishes')
    //   this.loading = false
    //   console.log('Wishes get from storage')
    // } else {
    //   this.$store.dispatch('wishes/getSelfWishes', this.$store.getters['users/getUser'])
    //     .then(isFailed => {
    //       if(isFailed) {
    //         Notify.create({
    //           type: 'negative',
    //           message: `Ошибка получения списка желаний: внутрення ошибка сервера`
    //         })
    //       } else {
    //         this.rows = this.$store.getters['wishes/getWishes']
    //         this.$stupidCache.saveData(this.rows, 'self-wishes')
    //       }
    //       this.loading = false
    //     })
    // }

    this.$store.dispatch('wishes/getSelfWishes', this.$store.getters['users/getUser'])
      .then(isFailed => {
        if(isFailed) {
          Notify.create({
            type: 'negative',
            message: `Ошибка получения списка желаний: внутрення ошибка сервера`
          })
        } else {
          this.rows = this.$store.getters['wishes/getWishes']
          console.log(this.rows)
        }
        this.loading = false
      })
  },
  methods: {
    onRowClick(evt, row) {
      this.editedWishData.id = row.id
      this.editedWishData.title = row.title
      this.editedWishData.description = row.description
      this.editedWishData.percentageOfImplementation = row.percentageOfImplementation
      this.isEditDialogOpened = !this.isEditDialogOpened
    },
    onAddButtonClick() {
      this.isCreateDialogOpened = !this.isCreateDialogOpened
    },
    onAddNewWishAccept() {

    },
    onEditDialogClosed() {
      this.editedWishData = {
        id: 0,
        title: '',
        description: '',
        percentageOfImplementation: 0.0
      }
      this.isEditDialogOpened = !this.isEditDialogOpened
    },
    onEditDialogAccept() {
      Loading.show()

      if(this.editedWishData.description.length === 0 || this.editedWishData.title.length === 0) {
        Notify.create({
          type: 'negative',
          message: `Ошибка редактирования желания: форма заполнена не полностью`
        })
        Loading.hide()
        return
      }

      let accessToken = { token: this.user.token }
      this.$store.dispatch('wishes/editWish', Object.assign(this.editedWishData, accessToken))
        .then(isFailed => {
          if(isFailed) {
            Notify.create({
              type: 'negative',
              message: `Ошибка редактирования желания: внутрення ошибка сервера`
            })
          } else  {
            this.loading = true
            this.$store.dispatch('wishes/getSelfWishes', this.$store.getters['users/getUser'])
              .then(isFailed => {
                if(isFailed) {
                  Notify.create({
                    type: 'negative',
                    message: `Ошибка получения списка желаний: внутрення ошибка сервера`
                  })
                } else {
                  this.rows = this.$store.getters['wishes/getWishes']
                  console.log(this.rows)
                }
                this.loading = false
              })
            // this.rows = this.$store.getters['wishes/getWishes']
            // console.log(this.rows)
            // this.$stupidCache.saveData(this.$store.getters['wishes/getWishes'], 'self-wishes')
            // this.rows = this.$stupidCache.getData('self-wishes')
          }
          Loading.hide()
        })
    },
    onArchived() {
      Loading.show()

      if(this.editedWishData.description.length === 0 || this.editedWishData.title.length === 0) {
        Notify.create({
          type: 'negative',
          message: `Ошибка редактирования желания: форма заполнена не полностью`
        })
        Loading.hide()
        return
      }

      let accessToken = { token: this.user.token }
      this.$store.dispatch('wishes/archiveWish', Object.assign(this.editedWishData, accessToken))
        .then(isFailed => {
          if(isFailed) {
            Notify.create({
              type: 'negative',
              message: `Ошибка редактирования желания: внутрення ошибка сервера`
            })
          } else  {
            this.onEditDialogClosed()
            this.loading = true
            this.$store.dispatch('wishes/getSelfWishes', this.$store.getters['users/getUser'])
              .then(isFailed => {
                if(isFailed) {
                  Notify.create({
                    type: 'negative',
                    message: `Ошибка получения списка желаний: внутрення ошибка сервера`
                  })
                } else {
                  this.rows = this.$store.getters['wishes/getWishes']
                  console.log(this.rows)
                }
                this.loading = false
              })
          }
          Loading.hide()
        })
    },
    buildProgressClass(percentageOfImplementation) {
      if(percentageOfImplementation === 1) {
        return 'flex column content-center bg-positive'
      }

      return  'flex column content-center'
    }
  },
})
</script>

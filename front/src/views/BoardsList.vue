<template>
  <div>
    <nav class="navbar" style="background-color: #f5f5f6">
      <div class="container-fluid">
        <router-link to="/boards/create">
          <span class="board-title-text">Новая доска</span>
        </router-link>

        <div v-on:click="tryLogout()" action="/logout" method="POST" @submit.prevent="$emit('logout')">
          <button class="btn btn btn-light btn-light-form-edit">
            <span>Выход</span>
          </button>
        </div>

      </div>
    </nav>

    <div v-if="boards">
      <div v-for="board in boards"
           :key="board.id"
           :data-board-id="`${board.id}`">

        <div class="card m-2" style="max-width: 240px;">
          <div class="row g-1">
            <div class="card-body input-group" style="padding: 0;">
              <router-link :to="`/boards/${board.id}`"
                           :data-board-title="board.title"
                           class="card-title form-control text-wrap stretched-link"
                           style="margin-bottom:0; border: none;">
                {{ board.title }}
              </router-link>

              <router-link :to="`/boards/${board.id}/edit`" role="button"
                           class="btn btn-outline-light d-flex  p-2 align-content-center flex-wrap">
                <img src="../icons/pen-fill.svg" alt="edit task" width="10" height="10">
              </router-link>

              <button v-on:click="onRemoveBoard(board.id)" type="button"
                      class="btn btn-light btn-light-form-edit">
                <img src="../icons/x.svg" alt="remove board" width="18" height="18">
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script setup>

import {getBoards, removeBoard, logout} from "../api.js"
import {ref} from "vue";
import {useRouter} from "vue-router";

const router = useRouter();

const boards = ref(null);

const isAuthenticated = ref(null);

const response = getBoards()
    .then(response => response.json())
    .then(json => {
      boards.value = json.data.boards;
    });

async function onRemoveBoard(boardId) {
  await removeBoard(boardId);
  boards.value = boards.value.filter(board => board.id !== boardId);
}

async function tryLogout() {

  const response = await logout()

  isAuthenticated.value = response.status === 200;

  if (isAuthenticated.value) {
    await router.push('/login');
  }
}

</script>

<style>

</style>

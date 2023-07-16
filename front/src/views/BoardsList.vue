<template>
  <div>
    <nav class="navbar" style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <!--      <a class="navbar-brand" href="#">TodoList</a>-->

        <router-link to="/boards/create">
          <div class="board-new-title">
            <span class="board-title-text">Новая доска</span>
          </div>
        </router-link>

        <router-link to="/logout">
          <div class="board-new-title">
            <span class="btn btn-primary">Выход</span>
          </div>
        </router-link>
      </div>
    </nav>

    <div class="" v-if="boards">
      <div v-for="board in boards"
           :key="board.id"
           :data-board-id="`${board.id}`">

        <div class="card mb-1" style="max-width: 240px;">
          <div class="row g-0">
            <div class="card-body input-group" style="padding: 0;">
              <router-link :to="`/boards/${board.id}`"
                           :data-board-title="board.title"
                           class="card-title form-control text-wrap stretched-link"
                           style="margin-bottom:0; border: none; font-size: larger;">
                {{ board.title }}
              </router-link>

              <router-link :to="`/boards/${board.id}/edit`" role="button"
                           class="btn btn-outline-light d-flex align-content-center flex-wrap">
                <img src="../icons/pen-fill.svg" alt="edit task" width="10" height="10">
              </router-link>

              <button v-on:click="onRemoveBoard(board.id)" type="button"
                      class="btn btn-outline-light d-flex align-content-center flex-wrap">
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

import {getBoards} from "../api.js"
import {removeBoard} from "../api.js"
import {ref} from "vue";
import {useRouter} from "vue-router";

const router = useRouter();

const boards = ref(null);

const response = getBoards()
    .then(response => response.json())
    .then(json => {
      boards.value = json.data.boards;
    });

async function onRemoveBoard(boardId) {
  await removeBoard(boardId);
  boards.value = boards.value.filter(board => board.id !== boardId);
}

</script>

<style>

</style>

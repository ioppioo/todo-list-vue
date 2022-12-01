<template>
  <div class="boards">

    <div class="logout">
      <router-link to="/logout"
                   class="board-title-text">Выход
      </router-link>
    </div>

    <div @click="createBoard" class="boards-board-new">
      <div v-on:click="createBoard()" class="board-new-title">
        <span class="board-title-text">Новая доска</span>
      </div>
    </div>

    <div v-for="board in boards" v-bind:key="board.id"
         class="board"
         :data-board-id="`${board.id}`">
      <button v-on:click="removeBoard(`${board.id}`)" class="button button-task-del js-board-remove">🞫</button>
      <div class="board-title">
        <router-link :to="`/boards/${board.id}`">
                                <span class="board-title-text"
                                      :data-board-title="board.title">
                                    {{board.title}}
                                </span>
        </router-link>
        <button v-on:click="editBoard(`${board.id}`)" class="button button-edit js-board-edit">✎</button>
      </div>
    </div>

  </div>

</template>

<script setup>

import {getBoards} from "../api.js"
import {createBoard} from "../api.js"
import {editBoard} from "../api.js"
import {removeBoard} from "../api.js"

const response = await getBoards();

const boards = (await response.json()).data.boards;

</script>

<style>

</style>
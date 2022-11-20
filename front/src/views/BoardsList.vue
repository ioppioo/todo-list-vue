<template>
  <div class="boards" >

    <div class="logout">
      <router-link to="/logout"
         class="board-title-text">Выход</router-link>
    </div>

    <div class="boards-board-new">
      <div class="board-new-title">
        <span class="board-title-text">Новая доска</span>
      </div>
    </div>

    <div v-for="board in boards" :key="board.id" class="board"
         data-board-id="{{ board.id }}"
    >
      <button class="button button-task-del js-board-remove">🞫</button>
      <div class="board-title">
        <router-link to="/boards/{{ board.id  }}">
                                <span class="board-title-text"
                                      data-board-title="{{ board.title }}">
                                    {{ board.title }}
                                </span>
        </router-link>
        <button class="button button-edit js-board-edit">✎</button>
      </div>
    </div>

  </div>

</template>

<script setup>
  import {getBoards} from "../api.js";

  const response = await getBoards();

  const boards = (await response.json()).data.boards;

</script>

<style>

</style>
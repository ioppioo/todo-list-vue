<template>
  <div>
    <nav class="navbar" style="background-color: #f5f5f6;">
      <div class="container-fluid">
        <span class="board-title-text">Создание новой доски</span>
        <router-link to="/boards">
          <span class="btn btn btn-light btn-light-form-edit">К списку досок</span>
        </router-link>
      </div>
    </nav>

    <div class="container py-5 px-5 mx-auto text-center">
      <form action="/boards" method="POST" @submit.prevent="$emit('boardTitle', boardTitle)">
        <div class="input-group">
          <div class="form-floating">
            <textarea v-model="boardTitle" class="form-control input" rows="1" id="title" name="boardTitle"
                      placeholder="Название доски">{{ boardTitle }}</textarea>
            <label for="title">Название доски</label>
          </div>
          <button v-on:click="onEditBoard" class="btn btn-light btn-light-form-edit">✓</button>
        </div>
      </form>
    </div>
  </div>

</template>

<script setup>

import {ref} from "vue";
import {useRouter, useRoute} from "vue-router";
import {createBoard, editBoard, getBoard} from "../api.js"

const router = useRouter();

const route = useRoute();

const boardId = route.params.id;

const boardTitle = ref('');

if (boardId) {
  getBoard(boardId)
      .then(response => response.json())
      .then(json => {
        boardTitle.value = json.data.title;
      })
}

async function onEditBoard() {
  if (boardId) {
    await editBoard(boardId, boardTitle.value);
  } else {
    await createBoard(boardTitle.value);
  }
  await router.push("/boards");
}

</script>

<style scoped>

</style>

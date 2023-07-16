<template>
  <div>
    <nav class="navbar" style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <span class="title-new-note">Список задач</span>
        <router-link :to="`/boards/${boardId}`">
          <span class="btn btn-primary">Назад</span>
        </router-link>
      </div>
    </nav>

    <div class="container py-5 px-5 mx-auto text-center">
      <form action="/task-lists" method="POST" @submit.prevent="$emit('title', title)">
        <div class="input-group">
          <span class="input-group-text">Название списка</span>
          <textarea v-model="title" class="form-control input align-middle" rows="1" id="title" name="title">{{ title }}</textarea>
          <button v-on:click="onEditTaskList" class="btn btn-outline-secondary">✓</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import {useRouter, useRoute} from "vue-router";
import {createTaskList, editTaskList, getTaskList} from "../api.js";

const router = useRouter();

const route = useRoute();

const taskListId = route.params.id;

let boardId = route.params.boardId;

const taskList = ref(null);

const title = ref('');

if (taskListId) {
  const response = getTaskList(taskListId)
      .then(response => response.json())
      .then(json => {
        taskList.value = json.data.taskList;
        title.value = taskList.value.title;
        boardId = taskList.value.board.id;
      })
}

async function onEditTaskList() {
  if (taskListId) {
    await editTaskList(taskListId, title.value);
  } else {
    await createTaskList(boardId, title.value);
  }
  await router.push(`/boards/${boardId}`);
}

</script>

<style scoped>

</style>

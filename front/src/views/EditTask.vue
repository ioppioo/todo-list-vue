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
      <form action="/tasks" method="POST" @submit.prevent="$emit('taskText', taskText)">
        <div class="input-group">
              <span class="input-group-text">Задача</span>
              <textarea v-model="taskText" class="form-control input" rows="1" id="taskText" name="taskText">
                {{ taskText }}
              </textarea>
              <button v-on:click="onEditTask" class="btn btn-outline-secondary">✓</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import {useRouter, useRoute} from "vue-router";
import {createTasks, editTask, getTask} from "../api.js";

const router = useRouter();

const route = useRoute();

let boardId = route.params.boardId;

let taskListId = route.params.taskListId;

let taskId = route.params.id;

const task = ref(null);

const taskText = ref('');

if (taskId) {
  const response = getTask(taskId)
      .then(response => response.json())
      .then(json => {
        task.value = json.data.task;
        taskText.value = task.value.text;
        taskListId = json.data.taskListId;
        boardId = json.data.boardId;
      })
}

async function onEditTask() {
  if (taskId) {
    await editTask(taskId, taskText.value);
  } else {
    await createTasks(taskListId, taskText.value);
  }
  await router.push(`/boards/${boardId}`);
}

</script>

<style scoped>

</style>

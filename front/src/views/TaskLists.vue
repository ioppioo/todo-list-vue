<template>
  <div class="notes" :data-board-id="`${$route.params.id}`">
    <div class="note">
      <div class="title-new-note">
        <router-link to="/boards" class="title-note-text">К списку досок</router-link>
      </div>
    </div>

    <div class="new-note">
      <router-link :to="`/boards/${id}/edit`" class="title-new-note">
        <span class="title-note-text">Новый список</span>
      </router-link>
    </div>

    <div class="note"
         v-for="taskList in taskLists"
         :key="taskList.id"
         :data-task-list-id="`${taskList.id}`">
      <button class="button button-task-new js-task-create">+</button>
      <button v-on:click="onRemoveTaskList(taskList.id)" class="button button-task-del js-note-remove">🞫</button>
      <div class="title-note">
                    <span class="title-note-text"
                          :data-task-list-title="taskList.title">
                        {{ taskList.title }}</span>
        <button class="button button-edit js-task-list-edit">✎</button>
      </div>

      <ol class="tasks"
          v-for="task in taskList.tasks"
          :key="task.id"
          :data-task-id="`${task.id}`">
        <li class="tasks__task {{ task.isDone ? 'done' : '' }}"
            data-task-id="{{ task.id }}">
          <button class="button button-done js-task-done">✓</button>
          <span class="tasks__task-text"
                :data-task-text="task.text">
            {{ task.text }}
          </span>
          <button class="button button-edit js-task-edit">✎</button>
          <button class="button button-tasks-remove js-task-remove"> 🞫</button>
        </li>
      </ol>
    </div>

  </div>

</template>

<script setup>

import {getBoard, removeBoard} from "../api.js"
import {useRoute} from "vue-router";
import {ref} from "vue";

const route = useRoute();

const id = route.params.id;

const response = await getBoard(id);

const taskLists = ref((await response.json()).data.taskLists);

async function onRemoveTaskList(taskListId) {
  await removeBoard(taskListId);
  taskLists.value = taskLists.value.filter(taskList => taskList.id !== taskListId);
}

</script>

<style>

</style>
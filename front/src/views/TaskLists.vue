<template>
    <div class="notes" :data-board-id="$route.params.id" >
    <div class="note">
      <div class="title-new-note">
        <router-link to="/boards" class="title-note-text">К списку досок</router-link>
      </div>
    </div>

    <div class="new-note">
      <div class="title-new-note">
        <span class="title-note-text">Новый список</span>
      </div>
    </div>

      <div class="new-note">
        <div class="title-new-note">
          <span class="title-note-text">Новый список</span>
        </div>
      </div>

    <div class="note"
         v-for="taskList in board"
         :key="taskList.id"
         :data-task-list-id="`${taskList.id}`">
      <button class="button button-task-new js-task-create">+</button>
      <button class="button button-task-del js-note-remove">🞫</button>
      <div class="title-note">
                    <span class="title-note-text"
                          :data-task-list-title="taskList.title">
                        {{ taskList.title }}</span>
        <button class="button button-edit js-task-list-edit">✎</button>
      </div>
<!--      <ol v-for="task in taskList" :key="task.id"-->
<!--          class="tasks">-->
<!--        <li class="tasks__task {{ task.isDone ? 'done' : '' }}"-->
<!--            data-task-id="{{ task.id }}">-->
<!--          <button class="button button-done js-task-done">✓</button>-->
<!--          <span class="tasks__task-text"-->
<!--                :data-task-text="task.text">-->
<!--            {{ task.text }}-->
<!--          </span>-->
<!--          <button class="button button-edit js-task-edit">✎</button>-->
<!--          <button class="button button-tasks-remove js-task-remove"> 🞫</button>-->
<!--        </li>-->
<!--      </ol>-->
    </div>

    </div>

<!--  </div>-->

</template>

<script setup>

import {getBoard} from "../api.js"

const response = await getBoard();

const board = (await response.json()).data.board;

</script>

<style>

</style>
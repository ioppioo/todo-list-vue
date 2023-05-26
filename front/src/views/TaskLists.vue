<template>
  <div>
    <nav class="navbar" style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <span class="title-new-note">Списки задач</span>

        <router-link :to="`/boards/${id}/task-lists/create`">
          <span>Новый список</span>
        </router-link>

        <router-link to="/boards" role="button">
          <span class="btn btn-primary">Назад</span>
        </router-link>
      </div>
    </nav>

    <div v-if="taskLists">
      <div v-for="taskList in taskLists"
           :key="taskList.id"
           :data-task-list-id="`${taskList.id}`">

        <div class="card border-primary mb-1" style="max-width: 240px;">

          <div class="card-header row g-0">
            <div class="col-md-8">
            <h5 class="card-title" :data-task-list-title="taskList.title">{{ taskList.title }}</h5>
            </div>

            <div class="col-md-4">
              <router-link :to="`/task-lists/${taskList.id}/edit`" role="button">
                <img src="../icons/pencil-square.svg" alt="edit tasklist title" width="16" height="16">
              </router-link>

              <button v-on:click="onRemoveTaskList(taskList.id)" type="button" class="btn btn-link">
                <img src="../icons/x-square.svg" alt="remove tasklist" width="16" height="16">
              </button>
            </div>

          </div>

          <ol class="list-group list-group-numbered">
            <li v-for="task in taskList.tasks"
                :key="task.id"
                :data-task-id="`${task.id}`"
                class="list-group-item">

              <input v-on:click="onTaskDone(task.id, task.isDone)"
                     v-bind="{ checked: task.isDone}"
                     class="form-check-input" type="checkbox" value="" id="flexCheckDefault">

              <span class="card-text form-check-label" for="flexCheckDefault" :data-task-text="task.text">{{
                  task.text
                }}</span>

              <router-link :to="`/task-lists/${taskList.id}/tasks/${task.id}/edit`"
                           role="button" class="btn btn-light btn-sm text-dark"
                           v-bind:class="{ 'button-hidden': task.isDone }">
                <img src="../icons/pen-fill.svg" alt="edit task" width="12" height="12">
              </router-link>

              <button v-on:click="onRemoveTask(task.id)" type="button" class="btn btn-light btn-sm text-dark">
                <img src="../icons/x.svg" alt="remove task" width="18" height="18">
              </button>
            </li>
          </ol>

          <div class="card-footer text-center">
            <router-link :to="`/boards/${id}/task-lists/${taskList.id}/tasks/create`" role="button" class="btn">
<!--              <img src="../icons/plus-lg.svg" alt="new task" width="16" height="16">-->
                  Новая задача
            </router-link>
          </div>

        </div>
      </div>
    </div>

  </div>

</template>

<script setup>
import {ref} from "vue";
import {getBoard, removeTask, removeTaskList, taskDone} from "../api.js"
import {useRoute, useRouter} from "vue-router";

const router = useRouter();

const route = useRoute();

const id = route.params.id;

const taskLists = ref(null);

const task = ref(null);

const response = await getBoard(id)
    .then(response => response.json())
    .then(json => {
      taskLists.value = json.data.taskLists;
      task.value = json.data.taskLists;
    });

async function onRemoveTaskList(taskListId) {
  await removeTaskList(taskListId);
  taskLists.value = taskLists.value.filter(taskList => taskList.id !== taskListId);
}

async function onRemoveTask(id) {
  await removeTask(id);
  task.value = task.value.filter(task => task.id !== id);
}

async function onTaskDone(id, isDone) {
  await taskDone(id, !isDone)
      .then(response => {
        if (response.ok) {
          isDone = true;
        }
      })
}

</script>

<style>

</style>

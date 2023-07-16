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

        <div class="card" style="max-width: 240px;">
          <div class="card-body input-group" style="padding: 0;">
            <span class="card-title form-control p-2 m-0 text-wrap"
                  style="border: none;"
                  :data-task-list-title="taskList.title">
              {{ taskList.title }}
            </span>

            <router-link :to="`/task-lists/${taskList.id}/edit`" role="button"
                         class="btn btn-outline-light d-flex p-2 align-content-center flex-wrap">
              <img src="../icons/pen-fill.svg" alt="edit taskList" width="10" height="10">
            </router-link>

            <button v-on:click="onRemoveTaskList(taskList.id)" type="button"
                    class="btn btn-outline-light d-flex p-2 align-content-center flex-wrap">
              <img src="../icons/x.svg" alt="remove taskList" width="18" height="18">
            </button>
          </div>

          <ul class="list-group list-group-flush"
              style="margin: 0; padding: 0;">
            <li v-for="task in taskList.tasks"
                :key="task.id"
                :data-task-id="`${task.id}`"
                class="list-group-item input-group d-flex ps-2 pe-0 py-0">

              <span class="li-counter align-middle my-auto text-wrap" style="min-width: 20px"> </span>

              <input v-on:click="onTaskDone(task.id, task.isDone)"
                     v-bind="{ checked: task.isDone }"
                     class="form-check-input btn btn-light m-0 p-0"
                     style="height: auto; border-radius: 0" type="checkbox" value=""
                     id="flexCheckDefault">

              <span v-bind:class="{'text-decoration-line-through ' :task.isDone}"
                    :data-task-text="task.text"
                    for="flexCheckDefault"
                    class="form-check-label flex-fill p-2 text-wrap"
                    style="width: 100px;">
                {{ task.text }}
              </span>

              <router-link :to="`/task-lists/${taskList.id}/tasks/${task.id}/edit`" role="button"
                           class="btn btn-group btn-outline-light p-2 align-content-center flex-wrap"
                           v-bind:class="{ 'visually-hidden' :task.isDone }">
                <img src="../icons/pen-fill.svg" alt="edit task" width="10" height="10">
              </router-link>


              <button v-on:click="onRemoveTask(task.id)" type="button"
                      class="btn btn-group btn-outline-light p-2 align-content-center flex-wrap">
                <img src="../icons/x.svg" alt="remove task" width="18" height="18">
              </button>

            </li>
          </ul>

          <div class="card-body text-center"
               style="padding: 0; border: none;">
            <router-link :to="`/boards/${id}/task-lists/${taskList.id}/tasks/create`" role="button"
                         class="btn btn-outline-light d-flex align-content-center flex-wrap">
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

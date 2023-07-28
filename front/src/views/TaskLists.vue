<template>
  <div>
    <nav class="navbar" style="background-color: #f5f5f6;">
      <div class="container-fluid">
        <span class="title-new-note">Списки задач</span>

        <router-link :to="`/boards/${id}/task-lists/create`">
          <span>Новый список</span>
        </router-link>

        <router-link to="/boards" role="button">
          <span class="btn btn-light btn-light-form-edit">Назад</span>
        </router-link>
      </div>
    </nav>

      <div class="container">
        <div v-if="taskLists" class="row mb-5"
             data-masonry='{"percentPosition": true }'>
          <div v-for="taskList in taskLists"
               :key="taskList.id"
               :data-task-list-id="`${taskList.id}`"
               class="col-4  mt-4 py-2 px-2" style="min-width: 240px;">

            <div class="card">
              <div class="card-body input-group" style="padding: 0;">
              <span class="card-header form-control m-0 p-2"
                    style="border: none;"
                    :data-task-list-title="taskList.title">
                {{ taskList.title }}
              </span>


                <router-link :to="`/task-lists/${taskList.id}/edit`" role="button"
                             class="btn btn-light d-flex m-0 p-2 align-content-center flex-wrap">
                  <img src="../icons/pen-fill.svg" alt="edit taskList" width="10" height="10">
                </router-link>

                <button v-on:click="onRemoveTaskList(taskList.id)" type="button"
                        class="btn btn-light btn-light-remove-taskList d-flex m-0 p-2 align-content-center flex-wrap">
                  <img src="../icons/x.svg" alt="remove taskList" width="18" height="18">
                </button>
              </div>

              <ol class="list-group list-group-flush"
                  style="margin: 0; padding: 0;">
                <Tasks v-for="(task, index) in taskList.tasks"
                       :index="index += 1"
                       :key="task.id"
                       v-bind="task"
                       @onTaskDone="onTaskDone(task.id, task.isDone)"
                       @onRemoveTask="onRemoveTask(task.id)"
                       @edit="onEditTask(taskList.id,task.id)"
                >
                </Tasks>
              </ol>

              <div class="card-footer"
                   style="padding: 0; border: none;">
                <router-link :to="`/boards/${id}/task-lists/${taskList.id}/tasks/create`" role="button"
                             class="btn btn-light btn-light-new-task d-flex justify-content-center flex-wrap">
                  Новая задача
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {getBoard, removeTask, removeTaskList, taskDone} from "../api.js";
import {useRoute, useRouter} from "vue-router";
import Tasks from "./Tasks.vue"

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
  await removeTask(id)
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

async function onEditTask(taskListId, taskId) {
  await router.push(`/task-lists/${taskListId}/tasks/${taskId}/edit`)
}

</script>

<style>

</style>

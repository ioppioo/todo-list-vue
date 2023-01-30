<template>
  <div>
    <div>
      <router-link to="/boards">
        <h1>back</h1>
      </router-link>
    </div>

    <form class="boards" action="/task-lists" method="POST" @submit.prevent="$emit('title', title)">
      <div class="notes">
        <div class="new-note">
          <input type="hidden" id="boardId" name="boardId" value="{{ id }}">
          <input type="hidden" id="taskListId" name="taskListId" value="{{ taskListId }}">
          <label class="title-note" for="task-list">
            <textarea v-model="title" class="input" rows="1" id="title" name="title">{{ title }}</textarea>
            <button v-on:click="onEditTaskList" class="button button-edit">✓</button>
          </label>
        </div>
      </div>
    </form>

  </div>
</template>

<script setup>
import {ref} from "vue";
import {useRouter, useRoute} from "vue-router";
import {createTaskList, editTaskList, getBoard} from "../api.js";

const router = useRouter();

const route = useRoute();

const id = 29;

const taskListId = route.params.id;

const title = ref('');

// const response = await getBoard();
//
// const boardId = ref((await response.json()).data.boardId);

async function onEditTaskList() {
  if (taskListId) {
    await editTaskList(taskListId, title.value);
  } else {
    await createTaskList(id, title.value);
  }
  await router.push(`/boards/${id}`);
}

</script>

<style scoped>

</style>

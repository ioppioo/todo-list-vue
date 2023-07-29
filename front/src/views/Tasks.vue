<script setup>

defineProps(['index', 'text', 'isDone', 'taskId', 'taskListId'])
defineEmits(['onTaskDone', 'onRemoveTask', 'edit'])


</script>

<template>

  <li class="list-group-item input-group d-flex ps-2 pe-0 py-0">
    <span class="align-middle my-auto text-wrap" style="min-width: 20px">{{ index }}</span>

    <input v-on:click="$emit('onTaskDone')"
           v-bind="{ checked: isDone }"
           class="form-check-input btn btn-light m-0 p-0"
           style="height: auto; border-radius: 0" type="checkbox" value=""
           id="flexCheckDefault">

    <span
        v-bind:class="{ 'task-done' :isDone }"
        for="flexCheckDefault"
        class="form-check-label flex-fill p-2 text-wrap"
        style="width: 100px;">
        {{ text }}
  </span>

    <button v-on:click="$emit('edit')"
            v-bind:class="{ 'visually-hidden' :isDone }"
            type="button"
            class="btn btn-light d-flex m-0 p-2 align-content-center flex-wrap">
      <img src="../icons/pen-fill.svg" alt="edit taskList" width="10" height="10">
    </button>

    <button v-on:click="$emit('onRemoveTask')"
            type="button"
            class="btn btn-group btn-light m-0 p-2 align-content-center flex-wrap">
      <img src="../icons/x.svg" alt="remove task" width="18" height="18">
    </button>
  </li>


</template>

<style>

</style>
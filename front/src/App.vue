<script setup>
import {ref} from "vue";
import {useRouter} from "vue-router";
import {me} from "./api.js";

const router = useRouter();

const isInit = ref(false);

const isAuthenticated = ref(false);

async function checkAuth() {
  const user = (await (await me()).json()).data.user;

  isAuthenticated.value = user !== null;

  if (!isAuthenticated.value) {
    await router.push('/auth')
  } else {
    await router.push('/boards')
  }

  isInit.value = true;
}

checkAuth();

</script>

<template>
  <h1 v-if="!isInit">loading...</h1>
  <router-view v-else @login="tryLogin"/>
</template>

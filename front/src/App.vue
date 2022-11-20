<script setup>
import {ref} from "vue";
import {useRouter} from "vue-router";
import {me} from "./api.js";
import {auth} from "./api.js";
import {signup} from "./api.js";

const router = useRouter();

const isInit = ref(false);

const isAuthenticated = ref(false);

async function checkAuth() {
  const user = (await (await me()).json()).data.user;

  isAuthenticated.value = user !== null;

  if (!isAuthenticated.value) {
    await router.push('/signup')
  } else {
    await router.push('/boards')
  }

  isInit.value = true;
}

checkAuth();

async function tryLogin(username, password) {

  const response = await auth(username, password);

  isAuthenticated.value = response.status === 200;

  if (isAuthenticated.value) {
    await router.push('/boards');
  } else {
    console.log('неверный пользователь или пароль');
  }
}

async function trySignup(login, email, password) {

  const response = await signup(login, email, password);

  isAuthenticated.value = response.status === 200;

  if (isAuthenticated.value) {
    await router.push('/login');
  } else {
    console.log('ошибка регистрации');
  }
}

</script>

<template>
  <h1 v-if="!isInit">loading...</h1>
  <router-view
      v-else
      @login="tryLogin"
      @signup="trySignup"
      @boards="tryBoards"
  />
</template>


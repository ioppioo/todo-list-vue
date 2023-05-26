<template>
  <div class="auth-container py-5 px-5 mx-auto text-center">
    <form class="" action="/signup" method="post" @submit.prevent="$emit('signup', login, email, password)">
      <div class="">
        <div class="form-floating" for="login">
          <input class="form-control" type="text" id="floatingLogin" name="login" v-model="login" placeholder="Логин">
          <label for="floatingLogin">Логин</label>
        </div>
      </div>
      <div>
        <div class="form-floating" for="email">
          <input type="text" id="floatingEmail" name="email" class="form-control" v-model="email" placeholder="Адрес электронной почты">
          <label for="floatingEmail">Адрес электронной почты</label>
        </div>
      </div>
      <div>
        <div class="form-floating" for="password">
          <input  type="password" id="floatingPassword" name="password" class="form-control" v-model="password" placeholder="Пароль">
          <label for="floatingPassword">Пароль</label>
        </div>
      </div>
      <div>
        <router-link to="/login">Войти</router-link>
      </div>
      <div>
        <button type="submit" class="btn btn-primary">Регистрация</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import {ref} from "vue";

const login = ref('');
const email = ref('');
const password = ref('');
</script>

<style scoped>

</style>
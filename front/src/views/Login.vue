<template>
  <div class="auth-container py-5 px-5 mx-auto text-center">
    <form class="inner-form" action="/login" method="post" @submit.prevent="$emit('login', login, password)">
      <div>
        <div class="form-floating" for="login">
          <input class="form-control"  type="text" id="floatingLogin" name="username" v-model="login" placeholder="Логин">
          <label for="floatingLogin">Логин</label>
        </div>
      </div>
      <div>
        <div class="form-floating" for="password">
          <input class="form-control"  type="password" id="password" name="password" v-model="password" placeholder="Пароль">
          <label for="floatingLogin">Пароль</label>
        </div>
      </div>
      <div class="a-signup">
        <router-link to="/signup">Регистрация</router-link>
      </div>
      <div>
        <button type="submit" class="btn btn-primary" >Войти</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import {ref} from "vue";

const login = ref('');
const password = ref('');
</script>

<style scoped>

</style>
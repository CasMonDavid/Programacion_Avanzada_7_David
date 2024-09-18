<script setup>
  import { ref } from 'vue'
  let count = ref(0)
  let varUno = ref(0)
  let varDos = ref(0)
  let resultado = ref(0)
  let texto = ref('')

  methods: {

  }
</script>

<template>
  <div class="cuerpo">
    <div id="titulo">
        <h1>Iniciar sesión</h1>
    </div>
    <div id="campos">
      <div id="campoCorreo">
        <label for="">Ingresar correo: </label>
        <input v-model="correo" type="text" placeholder="Correo">
      </div>
      <div id="campoPassword">
        <label for="">Ingresar contraseña: </label>
        <input v-model="password" type="password" placeholder="Contraseña">
      </div>
      <button>Acceder</button>
    </div>
  </div>
</template>

<style scoped>
  .cuerpo{
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: burlywood;
  }
  #titulo h1{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    font-weight: bold;
  }
  #campos{
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 30px;
    padding: 20px;
  }
  #campoCorreo{
    padding-bottom: 10px;
  }
  #campoPassword{
    padding-bottom: 10px;
  }
</style>

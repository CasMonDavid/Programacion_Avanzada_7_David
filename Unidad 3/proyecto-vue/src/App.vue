<script setup>
  import { ref } from 'vue'
  let count = ref(0)
  let varUno = ref(0)
  let varDos = ref(0)
  let resultado = ref(0)
  let texto = ref('')

  function Sumar(){
    resultado.value = Number(varUno.value)+Number(varDos.value)
  }

  defineProps({
    varUno: Number,
    varDos: Number,
    resultado: Number
  })
</script>

<template>
  <div class="cuerpo">
    <input class="m-i" v-model="texto" placeholder="Escribe tu nombre">
    <h3 class="m-i">Hola: {{ texto }}</h3>
    <button class="m-i" @click="count++">Haz oprimido este botón {{ count }} veces!!</button>
    <h3 class="m-i">Coloca 2 numeros y realiza una suma:</h3>
    <input class="suma" v-model="varUno" placeholder="Valor 1">
    <input class="suma" v-model="varDos" placeholder="valor 2">
    <button class="m-i" v-on:click="Sumar()"> S U M A R </button>
    <h4>{{ varUno }} + {{ varDos }} = {{ resultado }}</h4>
  </div>
</template>

<style scoped>
  .cuerpo{
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  input {
    width: 40%;
    height: 25px;
  }
  button {
    background-color: aliceblue;
    color: black;
    font-weight: bold;
  }
  .m-i{
    margin-bottom: 10px;
  }
  .suma {
    width: 200px;
  }
</style>

<script setup>
  import { ref, onMounted, onUpdated, onUnmounted } from 'vue'
  let users = ref([])
  let name = ref('')
  let username = ref('')
  let email = ref('')
  let phone = ref('')
  let password = ref('')
  let isLogin = ref(false)
  let isAddNewUser = ref(false)
  
  function checkSession(){
   name.value = localStorage.getItem('SessionName')
    if (nameSession!=undefined){
      isLogin=true;
      console.log("Nombre de la sesion: "+nameSession);
    }else{
      console.log("No hay ninguna sesion");
    }
  };

  function onSubmit(){
    fetch('./users.json') 
    .then(res => res.json())
    .then((response) => {
      users = response
      response.forEach((e) => {
        if (e.email == email.value){
          if (e.password == password.value){
            isLogin.value = true
            sessionStorage.setItem('SessionName',e.name)
            name.value = sessionStorage.getItem("SessionName")
            alert("Bienvenido al sistema "+e.name)
          }
        }
      })
    }).catch((error) => {
      console.error('Error durante la recoleción de datos :', error)
    });
  }

  onMounted(() => {
    name.value = sessionStorage.getItem("SessionName")

    fetch('./users.json') 
    .then(res => res.json())
    .then((response) => {
      users.value = response
    }).catch((error) => {
      console.error('Error durante la recoleción de datos :', error)
    });

    if (name.value!=undefined){
      console.log("Sesion abierta de: "+name.value)
      isLogin.value = true;
    }
    console.log("los componentes son montados ")
  })
</script>

<template>
  <div class="cuerpo">
    <form v-if="!isLogin" @submit.prevent="onSubmit">
      <div id="titulo">
        <h1>Iniciar sesión</h1>
      </div>
      <fieldset id="campoCorreo">
        <label for="">Ingresar correo: </label>
        <input v-model="email" type="text" placeholder="Correo">
      </fieldset>
      <fieldset id="campoPassword">
        <label for="">Ingresar contraseña: </label>
        <input v-model="password" type="password" placeholder="Contraseña">
      </fieldset>
      <button type="submit">Acceder</button>
    </form>
    <div v-else>
      <h2>Bienvenido {{ name }}</h2>
      <div v-if="!isAddNewUser">
        <table>
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Nombre de usuario</th>
              <th>Correos</th>
              <th>Teléfonos</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="dato in users">
              <td>
                {{ dato.name }}
              </td>
              <td>
                {{ dato.username }}
              </td>
              <td>
                {{ dato.email }}
              </td>
              <td>
                {{ dato.phone }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
      <form>
        <fieldset>
          <label for="">Agregar un nombre: </label>
          <input type="text" name="" id="name" v-model="name" placeholder="name">
        </fieldset>
        <fieldset>
          <label for="">Agregar un nombre de usuario: </label>
          <input type="text" name="" id="username" v-model="username" placeholder="username">
        </fieldset>
        <fieldset>
          <label for="">Agregar un correo: </label>
          <input type="text" name="" id="email" v-model="email" placeholder="email">
        </fieldset>
        <fieldset>
          <label for="">Agregar un numero telefonico: </label>
          <input type="text" name="" id="phone" v-model="phone" placeholder="phone">
        </fieldset>
        <button type="submit">Summit</button>
      </form>
      </div>
    </div>
    
  </div>
</template>

<style scoped>
  .cuerpo{
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: burlywood;
    padding: 30px;
  }
  #titulo{
    display: flex;
    flex-direction: column;
    align-items: center;
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
  h2{
    margin: 10px 0px;
  }
  thead{
    background-color: lightblue;
  }
  tbody{
    background-color: lightgray;
  }
</style>

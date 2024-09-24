<script setup>
  import { ref, onMounted } from 'vue'
  let users = ref([])
  let SessionName = ref('')
  let id = ref(0)
  let name = ref('')
  let username = ref('')
  let email = ref('')
  let phone = ref('')
  let password = ref('')
  let isLogin = ref(false)
  let isAddNewUser = ref(false)
  let isEditUser = ref(false)
  
  function changeIsAddNewUser(){
    isAddNewUser.value = !isAddNewUser.value;
  }

  function changeIsEditUser(){
    isEditUser.value = !isEditUser.value;
    isAddNewUser.value = !isAddNewUser.value;

    clearParams()
  }

  function addNewUser(){
    let newUser = {
      id: (users.value.length+1),
      name: name.value,
      username: username.value,
      email: email.value,
      password: "abc123",
      phone: phone.value
    }
    users.value.push(newUser)
    console.log(users.value)
    clearParams()
    changeIsAddNewUser()
  }

  function onSubmit(){
    fetch('./users.json') 
    .then(res => res.json())
    .then((response) => {
      let responseString = JSON.parse(JSON.stringify(response))
      users.value = responseString
      response.forEach((e) => {
        if (e.email == email.value){
          if (e.password == password.value){
            isLogin.value = true
            sessionStorage.setItem('SessionName',e.name)
            SessionName.value = sessionStorage.getItem("SessionName")
            alert("Bienvenido al sistema "+e.name)
            email.value=""
            password.value=""
          }
        }
      })
    }).catch((error) => {
      console.error('Error durante la recoleción de datos :', error)
    });
  }

  function deleteUser (id){
    users.value.splice((id-1),1)
  }

  function clearParams(){
    id=0
    name.value=""
    username.value =""
    email.value=""
    phone.value=""
    password=""
  }

  function editUser (idUser){
    changeIsEditUser()
    
    const user = users.value.find((element) => element.id == idUser)
    id = idUser
    name.value = user.name
    username.value = user.username
    email.value = user.email
    password = user.password
    phone.value = user.phone
  }

  function editUserConfirm(){
    console.log("Id: "+id)
    console.log(users.value)
    let confirmDataUser = {
      id: id,
      name: name.value,
      username: username.value,
      email: email.value,
      password: password,
      phone: phone.value
    }
    users.value.splice((id-1),1,confirmDataUser)
    console.log("Despues de de ejecutar: ")
    console.log(users.value)

    changeIsEditUser()
  }

  onMounted(() => {
    SessionName.value = sessionStorage.getItem("SessionName")

    fetch('./users.json') 
    .then(res => res.json())
    .then((response) => {
      let responseString = JSON.parse(JSON.stringify(response))
      users.value = responseString
    }).catch((error) => {
      console.error('Error durante la recoleción de datos :', error)
    });

    if (SessionName.value!=undefined){
      console.log("Sesion abierta de: "+SessionName.value)
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
        <legend for="">Ingresar correo </legend>
        <input v-model="email" type="text" placeholder="Correo">
      </fieldset>
      <fieldset id="campoPassword">
        <legend for="">Ingresar contraseña </legend>
        <input v-model="password" type="password" placeholder="Contraseña">
      </fieldset>
      <button type="submit">Acceder</button>
    </form>
    <div v-else>
      <h2>Bienvenido {{ SessionName }}</h2>
      <div v-if="!isAddNewUser">
        <button @click="changeIsAddNewUser">Agregar un usuario</button>
        <table>
          <thead>
            <tr>
              <th>Identificador</th>
              <th>Nombre</th>
              <th>Nombre de usuario</th>
              <th>Correos</th>
              <th>Teléfonos</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="dato in users">
              <td>
                {{ dato.id }}
              </td>
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
              <td>
                <button @click="editUser(dato.id)" >Editar</button>
                <button @click="deleteUser(dato.id)" >Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else-if="isEditUser">
        <form @submit.prevent="editUserConfirm">
          <fieldset>
            <legend>Editar nombre </legend>
            <input type="text" id="name" v-model="name" placeholder="Nombre" required>
          </fieldset>
          <fieldset>
            <legend>Editar nombre de usuario </legend>
            <input type="text" id="username" v-model="username" placeholder="Nombre de usuario" required>
          </fieldset>
          <fieldset>
            <legend>Editar correo </legend>
            <input type="text" id="email" v-model="email" placeholder="Correo" required>
          </fieldset>
          <fieldset>
            <legend>Editar número telefónico </legend>
            <input type="text" id="phone" v-model="phone" placeholder="Teléfono" required>
          </fieldset>
          <button type="submit">Confirmar cambios</button>
          <button @click="changeIsEditUser">Cancelar</button>
        </form>
      </div>
      <div v-else>
        <form @submit.prevent="addNewUser">
          <fieldset>
            <legend>Agregar un nombre </legend>
            <input type="text" id="name" v-model="name" placeholder="Nombre" required>
          </fieldset>
          <fieldset>
            <legend>Agregar un nombre de usuario </legend>
            <input type="text" id="username" v-model="username" placeholder="Nombre de usuario" required>
          </fieldset>
          <fieldset>
            <legend>Agregar un correo </legend>
            <input type="text" id="email" v-model="email" placeholder="Correo" required>
          </fieldset>
          <fieldset>
            <legend>Agregar un número telefónico </legend>
            <input type="text" id="phone" v-model="phone" placeholder="Teléfono" required>
          </fieldset>
          <button type="submit">Agregar</button>
          <button @click="changeIsAddNewUser">Cancelar</button>
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

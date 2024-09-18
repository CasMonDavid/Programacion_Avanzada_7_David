<script setup>
  import { ref } from 'vue'
  let name = ref('David')
  let username = ref('')
  let email = ref('')
  let phone = ref('')
  let isLogin = ref(false)
  let isAddNewUser = ref(false)

  methods: {
    function onSubmit()
        {
	    		console.log(this.email) 
	    		console.log(this.password)  

	    		fetch('users.json',) 
	    		.then(res=>res.json())
	    		.then((response) => { 

				    response.forEach((e) => {

				    	if (e.email==this.email) {
				    		if(e.password == this.password){

				    			console.log("Login")
				    			this.isLogin = true
				    		}
				    	}

				    });

				    if (!this.isLogin) {
				    	alert("Verifique su información")
				    }


				 })
	    		.catch((error) => {
				    
	    			alert("Ha ocurrido un error")

				});
	    }
  }
</script>

<template>
  <div class="cuerpo">
    <div v-if="!isLogin">
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
        <button type="submit">Acceder</button>
      </div>
    </div>
    <div v-else>
      <h2>Bienvenido {{ name }}</h2>
      <div v-if="!isAddNewUser">

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
</style>
